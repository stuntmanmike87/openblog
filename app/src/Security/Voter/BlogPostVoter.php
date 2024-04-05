<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Posts;
use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
// use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

final class BlogPostVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';
    public const DELETE = 'POST_DELETE';

    /* private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    } */

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE], true)) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Posts) {
            return false;
        }

        return true;
        // return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE], true) && $subject instanceof Posts;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var Users $user */
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) { // Users
            return false;
        }

        // if($this->security->isGranted('ROLE_ADMIN')) return true;

        // you know $subject is a Posts object, thanks to `supports()`
        /** @var Posts $post */
        $post = $subject;

        return match ($attribute) {
            self::VIEW => $this->canView($post, $user),
            self::EDIT => $this->canEdit($post, $user),
            self::DELETE => $this->canDelete($post, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
        // return $user === $post->getAuthor();
    }

    private function canView(Posts $post, Users $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($post, $user)) {
            return true;
        }

        // the Post object could have, for example, a method `isPrivate()`
        return false; // return !$post->isPrivate();
    }

    private function canEdit(Posts $post, Users $user): bool
    {
        // this assumes that the Post object has a `getUsers()` method // getOwner()
        return $user === $post->getUsers(); // return $user === $post->getOwner();
        // return $this->security->isGranted('ROLE_PRODUCT_ADMIN');
    }

    private function canDelete(Posts $post, Users $user): bool
    {
        return false;
        // return $this->security->isGranted('ROLE_ADMIN');
    }
}
