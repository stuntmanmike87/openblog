<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/** @final */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isReply = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    // #[ORM\ManyToMOne(targetEntity: self::class, inversedBy: 'comment')]
    // private ?self $comment = null;
    /** @var Collection<int, Comment> $comments */
    #[ORM\ManyToMany(targetEntity: Comment::class, inversedBy: 'comment')]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection // ?self
    {
        return $this->comments;
    }

    public function setComment(?self $comment): static
    {
        $comments = $this->getComments();
        /** @var Comment $comments */
        $comments = $comment;

        return $comments;
    }

    public function addComment(self $comment): static
    {
        $comments = $this->getComments();
        if (!$comments->contains($comment)) {
            $comments->add($comment);
            $comment->setComment($this);
        }

        return $this;
    }

    public function removeComment(self $comment): static
    {
        $comments = $this->getComments();
        if ($comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getComments() === $this) {
                $comment->setComment(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }
}
