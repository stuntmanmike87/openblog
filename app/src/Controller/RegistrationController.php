<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\SendEmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

final class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UsersAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
        JWTService $jwt,
        SendEmailService $mail
    ): ?Response {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        /** @var string $data */
        $data = $form->get('email')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $data
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // Générer le token
            // Header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256',
            ];

            // Payload
            /** @var array<string> $payload */ // @var (null|int)[] $payload
            $payload = [
                'user_id' => $user->getId(),
            ];

            // On génère le token
            /** @var string $param */
            $param = $this->getParameter('app.jwtsecret');
            $token = $jwt->generate($header, $payload, $param);

            // Envoyer l'e-mail
            /** @var array<string> $context */
            $context = compact('user', 'token');
            $mail->send(
                'no-reply@openblog.test',
                (string) $user->getEmail(),
                'Activation de votre compte sur le site OpenBlog',
                'register',
                $context // ['user' => $user, 'token'=>$token]
            );

            $this->addFlash('success', 'Utilisateur inscrit, veuillez cliquer sur le lien reçu pour confirmer votre adresse e-mail');

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifUser(
        string $token,
        JWTService $jwt,
        UsersRepository $usersRepository,
        EntityManagerInterface $em
    ): Response {
        // On vérifie si le token est valide (cohérent, pas expiré et signature correcte)
        /** @var string $param */
        $param = $this->getParameter('app.jwtsecret');
        if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $param)) {
            // Le token est valide
            // On récupère les données (payload)
            $payload = $jwt->getPayload($token);

            // On récupère le user
            $user = $usersRepository->find($payload['user_id']);

            // On vérifie qu'on a bien un user et qu'il n'est pas déjà activé
            /** @var Users $user */
            /** @var bool $verifiedUser */
            $verifiedUser = $user->isVerified();
            if (null !== $user && !$verifiedUser) {
                $user->setIsVerified(true);
                $em->flush();

                $this->addFlash('success', 'Utilisateur activé');

                return $this->redirectToRoute('app_main');
            }
        }
        $this->addFlash('danger', 'Le token est invalide ou a expiré');

        return $this->redirectToRoute('app_login');
    }
}
