<?php

namespace CuisineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity(repositoryClass="CuisineBundle\Repository\PanierRepository")
 */
class Panier
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
     * @ORM\OneToMany(targetEntity="Produit_panier", mappedBy="panier", cascade={"persist"})
     */
    private $produitCommandes;

    public function __construct()
    {
        $this->produitCommandes = new ArrayCollection();
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
     * Add produitCommande
     *
     * @param \CuisineBundle\Entity\Produit_panier $produitCommande
     *
     * @return Panier
     */
    public function addProduitCommande(\CuisineBundle\Entity\Produit_panier $produitCommande)
    {
        $this->produitCommandes[] = $produitCommande;

        return $this;
    }

    /**
     * Remove produitCommande
     *
     * @param \CuisineBundle\Entity\Produit_panier $produitCommande
     */
    public function removeProduitCommande(\CuisineBundle\Entity\Produit_panier $produitCommande)
    {
        $this->produitCommandes->removeElement($produitCommande);
    }

    /**
     * Get produitCommandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduitCommandes()
    {
        return $this->produitCommandes;
    }
}
