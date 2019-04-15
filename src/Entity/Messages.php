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
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages_envoyes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_envoi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages_recu")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_recoit;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserEnvoi(): ?User
    {
        return $this->user_envoi;
    }

    public function setUserEnvoi(?User $user_envoi): self
    {
        $this->user_envoi = $user_envoi;

        return $this;
    }

    public function getUserRecoit(): ?User
    {
        return $this->user_recoit;
    }

    public function setUserRecoit(?User $user_recoit): self
    {
        $this->user_recoit = $user_recoit;

        return $this;
    }
}
