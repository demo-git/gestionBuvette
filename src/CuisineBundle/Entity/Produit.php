<?php

namespace CuisineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="CuisineBundle\Repository\ProduitRepository")
 */
class Produit
{
    const TYPE_DRINK = 0;
    const TYPE_SNACK = 2;
    const TYPE_FOOD = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="pathImage", type="string", length=255)
     */
    private $pathImage;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var bool
     *
     * @ORM\Column(name="vendable", type="boolean")
     */
    private $vendable;

    /**
     * @ORM\OneToMany(targetEntity="Composant", mappedBy="produitComposant", cascade={"persist"})
     */
    private $composants;

    public function __construct()
    {
        $this->composants = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Produit
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Produit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set pathImage
     *
     * @param string $pathImage
     *
     * @return Produit
     */
    public function setPathImage($pathImage)
    {
        $this->pathImage = $pathImage;

        return $this;
    }

    /**
     * Get pathImage
     *
     * @return string
     */
    public function getPathImage()
    {
        return $this->pathImage;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Produit
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set vendable
     *
     * @param integer $vendable
     *
     * @return Produit
     */
    public function setVendable($vendable)
    {
        $this->vendable = $vendable;

        return $this;
    }

    /**
     * Get vendable
     *
     * @return int
     */
    public function getVendable()
    {
        return $this->vendable;
    }

    /**
     * Add composant
     *
     * @param \CuisineBundle\Entity\Composant $composant
     *
     * @return Produit
     */
    public function addComposant(\CuisineBundle\Entity\Composant $composant)
    {
        $this->composants[] = $composant;

        return $this;
    }

    /**
     * Remove composant
     *
     * @param \CuisineBundle\Entity\Composant $composant
     */
    public function removeComposant(\CuisineBundle\Entity\Composant $composant)
    {
        $this->composants->removeElement($composant);
    }

    /**
     * Get composants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComposants()
    {
        return $this->composants;
    }
}
