<?php

namespace App\Entity;

use App\Repository\UserStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserStatusRepository::class)]
class UserStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $userId;

    #[ORM\Column(type: 'boolean')]
    private $isSingle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getIsSingle(): ?bool
    {
        return $this->isSingle;
    }

    public function setIsSingle(bool $isSingle): self
    {
        $this->isSingle = $isSingle;

        return $this;
    }
}
