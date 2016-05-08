<?php

namespace CuisineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Composant
 *
 * @ORM\Table(name="composant")
 * @ORM\Entity(repositoryClass="CuisineBundle\Repository\ComposantRepository")
 */
class Composant
{
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
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="Produit", inversedBy="composants")
     * @ORM\JoinColumn(name="produit_composant_id", referencedColumnName="id")
     */
    private $produitComposant;

    /**
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumn(name="produit_compose_id", referencedColumnName="id")
     */
    private $produitCompose;


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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Composant
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
     * Set produitComposant
     *
     * @param \CuisineBundle\Entity\Produit $produitComposant
     *
     * @return Composant
     */
    public function setProduitComposant(\CuisineBundle\Entity\Produit $produitComposant = null)
    {
        $this->produitComposant = $produitComposant;

        return $this;
    }

    /**
     * Get produitComposant
     *
     * @return \CuisineBundle\Entity\Produit
     */
    public function getProduitComposant()
    {
        return $this->produitComposant;
    }

    /**
     * Set produitCompose
     *
     * @param \CuisineBundle\Entity\Produit $produitCompose
     *
     * @return Composant
     */
    public function setProduitCompose(\CuisineBundle\Entity\Produit $produitCompose = null)
    {
        $this->produitCompose = $produitCompose;

        return $this;
    }

    /**
     * Get produitCompose
     *
     * @return \CuisineBundle\Entity\Produit
     */
    public function getProduitCompose()
    {
        return $this->produitCompose;
    }
}
