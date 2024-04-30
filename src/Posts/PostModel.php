<?php

declare(strict_types=1);

namespace Bojan\PhpGrapejs\Posts;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'posts')]
class PostModel
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id = 0;

    #[ORM\Column(type: 'string')]
    private string $title = '';

    #[ORM\Column(type: 'string')]
    private string $content = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function toObject(): object
    {
        return (object) [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}