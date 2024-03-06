<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;use Doctrine\Common\Collections\Collection;

/** @final */
#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isReply = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'comments')]
    private ?self $comments = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Posts $posts = null;

    public function __construct()
    {
        //$this->comments = new ArrayCollection();
        $c = new ArrayCollection();
        /** @var Comments $c */
        $this->comments = $c;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function isIsReply(): ?bool
    {
        return $this->isReply;
    }

    public function setIsReply(bool $isReply): static
    {
        $this->isReply = $isReply;

        return $this;
    }

    public function getComments(): ?self
    {
        return $this->comments;
    }

    public function setComments(?self $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function addComment(self $comment): static
    {   
        /** @var Collection<int, Comments> $comments */
        $comments = $this->getComments();
        if (!$comments->contains($comment)) {
            $comments->add($comment);
            $comment->setComments($this);
        }

        return $this;
    }

    public function removeComment(self $comment): static
    {
        /** @var Collection<int, Comments> $comments */
        $comments = $this->getComments();
        if ($comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getComments() === $this) {
                $comment->setComments(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getPosts(): ?Posts
    {
        return $this->posts;
    }

    public function setPosts(?Posts $posts): static
    {
        $this->posts = $posts;

        return $this;
    }
}
