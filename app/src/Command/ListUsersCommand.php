<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:list-user',
    description: 'Lists all the existing user',
    aliases: ['app:user']
)]
final class ListUserCommand extends Command
{
    public function __construct(
        private readonly MailerInterface $mailer,
        #[Autowire('%app.notifications.email_sender%')]
        private readonly string $emailSender,
        private readonly UserRepository $user,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp(<<<'HELP'
                The <info>%command.name%</info> command lists all the user registered in the application:

                <info>php %command.full_name%</info>

                By default the command only displays the 50 most recent user. Set the number of
                results to display with the <comment>--max-results</comment> option:

                <info>php %command.full_name%</info> <comment>--max-results=2000</comment>

                In addition to displaying the user list, you can also send this information to
                the email address specified in the <comment>--send-to</comment> option:

                <info>php %command.full_name%</info> <comment>--send-to=fabien@symfony.com</comment>
                HELP
            )
            // commands can optionally define arguments and/or options (mandatory and optional)
            // see https://symfony.com/doc/current/components/console/console_arguments.html
            ->addOption('max-results', null, InputOption::VALUE_OPTIONAL, 'Limits the number of user listed', 50)
            ->addOption('send-to', null, InputOption::VALUE_OPTIONAL, 'If set, the result is sent to the given email address')
        ;
    }

    /**
     * This method is executed after initialize(). It usually contains the logic
     * to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var int|null $maxResults */
        $maxResults = $input->getOption('max-results');

        // Use ->findBy() instead of ->findAll() to allow result sorting and limiting
        $allUser = $this->user->findBy([], ['id' => 'DESC'], $maxResults);

        $createUserArray = static function (User $user): array {
            return [
                $user->getId(),
                // $user->getFullName(),
                $user->getNickname(),
                $user->getEmail(),
                implode(', ', $user->getRoles()),
            ];
        };

        // Doctrine query returns an array of objects, and we need an array of plain arrays
        $userAsPlainArrays = array_map($createUserArray, $allUser);

        // In your console commands you should always use the regular output type,
        // which outputs contents directly in the console window. However, this
        // command uses the BufferedOutput type instead, to be able to get the output
        // contents before displaying them. This is needed because the command allows
        // to send the list of user via email with the '--send-to' option
        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io->table(
            ['ID', /* 'Full Name', */ 'Nickname', 'Email', 'Roles'],
            $userAsPlainArrays
        );

        // instead of just displaying the table of user, store its contents in a variable
        $userAsATable = $bufferedOutput->fetch();
        $output->write($userAsATable);

        /** @var string|null $email */
        $email = $input->getOption('send-to');

        if (null !== $email) {
            $this->sendReport($userAsATable, $email);
        }

        return Command::SUCCESS;
    }

    /**
     * Sends the given $contents to the $recipient email address.
     */
    private function sendReport(string $contents, string $recipient): void
    {
        $email = (new Email())
            ->from($this->emailSender)
            ->to($recipient)
            ->subject(sprintf('app:list-user report (%s)', date('Y-m-d H:i:s')))
            ->text($contents);

        $this->mailer->send($email);
    }
}
