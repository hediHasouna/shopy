<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
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
    private $orderId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryAdresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryCountry;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deliveryZipCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryCity;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="idCommande")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getDeliveryName(): ?string
    {
        return $this->deliveryName;
    }

    public function setDeliveryName(?string $deliveryName): self
    {
        $this->deliveryName = $deliveryName;

        return $this;
    }

    public function getDeliveryAdresse(): ?string
    {
        return $this->deliveryAdresse;
    }

    public function setDeliveryAdresse(?string $deliveryAdresse): self
    {
        $this->deliveryAdresse = $deliveryAdresse;

        return $this;
    }

    public function getDeliveryCountry(): ?string
    {
        return $this->deliveryCountry;
    }

    public function setDeliveryCountry(?string $deliveryCountry): self
    {
        $this->deliveryCountry = $deliveryCountry;

        return $this;
    }

    public function getDeliveryZipCode(): ?int
    {
        return $this->deliveryZipCode;
    }

    public function setDeliveryZipCode(?int $deliveryZipCode): self
    {
        $this->deliveryZipCode = $deliveryZipCode;

        return $this;
    }

    public function getDeliveryCity(): ?string
    {
        return $this->deliveryCity;
    }

    public function setDeliveryCity(?string $deliveryCity): self
    {
        $this->deliveryCity = $deliveryCity;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setIdCommande($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getIdCommande() === $this) {
                $article->setIdCommande(null);
            }
        }

        return $this;
    }
}
