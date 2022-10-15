<?php

namespace App\Entity;

use App\Repository\ClubStRepository;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubStRepository::class)]
class ClubSt
{
    #[ORM\Id]
    // #[ORM\GeneratedValue]
    #[ORM\Column(length: 255)]
    private ?string $ref = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

  
   

   


    public function getRef(): ?string
    {
        return $this->ref;
    }
    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

   

   
   
  
    
}
