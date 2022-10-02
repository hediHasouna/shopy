<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $itemId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $itemQuantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $linePriceExclVat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $linePriceInclVat;

    /**
     * @ORM\ManyToOne(targetEntity=commande::class, inversedBy="articles")
     */
    private $idCommande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    public function setItemId(?string $itemId): self
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function getItemQuantity(): ?int
    {
        return $this->itemQuantity;
    }

    public function setItemQuantity(?int $itemQuantity): self
    {
        $this->itemQuantity = $itemQuantity;

        return $this;
    }

    public function getLinePriceExclVat(): ?float
    {
        return $this->linePriceExclVat;
    }

    public function setLinePriceExclVat(?float $linePriceExclVat): self
    {
        $this->linePriceExclVat = $linePriceExclVat;

        return $this;
    }

    public function getLinePriceInclVat(): ?float
    {
        return $this->linePriceInclVat;
    }

    public function setLinePriceInclVat(?float $linePriceInclVat): self
    {
        $this->linePriceInclVat = $linePriceInclVat;

        return $this;
    }

    public function getIdCommande(): ?commande
    {
        return $this->idCommande;
    }

    public function setIdCommande(?commande $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }
}
