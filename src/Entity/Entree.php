<?php

namespace App\Entity;

use App\Repository\EntreeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\FormInterface;


#[ORM\Entity(repositoryClass: EntreeRepository::class)]
class Entree
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 800)]
    private $ingredients;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $brochureFilename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function addEntree(Entree $entree): self
    {
        if (!$this->Entree->contains($entree)) {
            $this->Entree[] = $entree;
        }
        return $this;
    }

//    /**
//     * @ORM\Column(type="string")
//     */
//    private $brochureFilename;

    public function getBrochureFilename()
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename($brochureFilename)
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }





}
