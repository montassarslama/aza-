<?php

namespace App\Entity;

class Recherche
{

    private $nomlivreur;


    public function getNomlivreur(): ?string
    {
        return $this->nomlivreur;
    }

    public function setNomlivreur(string $nomlivreur): self
    {
        $this->nomlivreur = $nomlivreur;

        return $this;
    }
}