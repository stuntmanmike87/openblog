<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @template TAttribute of string
 * @template TSubject of mixed
 *
 * @extends Voter<TAttribute, Post>
 */
final class BlogPostVoter extends Voter
{
    public const string EDIT = 'POST_EDIT';
    public const string VIEW = 'POST_VIEW';
    public const string DELETE = 'POST_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE], true)) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Post) {
            return false;
        }

        return true;
        // return in_array(
        //     $attribute,
        //     [self::EDIT, self::VIEW, self::DELETE],
        //     true
        // ) && $subject instanceof Post;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // you know $subject is a Post object, thanks to `supports()`
        $post = $subject;

        return match ($attribute) {
            self::VIEW => $this->canView($post, $user),
            self::EDIT => $this->canEdit($post, $user),
            self::DELETE => $this->canDelete($post, $user),
            default => throw new \LogicException('This code should not be reached!'),
        };
        // return $user === $post->getAuthor();
    }

    private function canView(Post $post, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($post, $user)) {
            return true;
        }

        // the Post object could have, for example, a method `isPrivate()`
        return false;
        // return !$post->isPrivate();
    }

    private function canEdit(Post $post, User $user): bool
    {
        // this assumes that the Post object has a `getUser()` method // getOwner()
        return $user === $post->getUser();
        // return $user === $post->getOwner();
    }

    private function canDelete(Post $post, User $user): bool
    {
        return false;
    }
}
