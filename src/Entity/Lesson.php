<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private $Section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->Section;
    }

    public function setSection(?Section $Section): self
    {
        $this->Section = $Section;

        return $this;
    }
}
