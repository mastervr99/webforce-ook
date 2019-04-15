<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessagesRepository")
 */
class Messages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $User_envoi;

    /**
     * @ORM\Column(type="integer")
     */
    private $User_recoit;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePublication;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserEnvoi(): ?int
    {
        return $this->User_envoi;
    }

    public function setUserEnvoi(int $User_envoi): self
    {
        $this->User_envoi = $User_envoi;

        return $this;
    }

    public function getUserRecoit(): ?int
    {
        return $this->User_recoit;
    }

    public function setUserRecoit(int $User_recoit): self
    {
        $this->User_recoit = $User_recoit;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }
}
