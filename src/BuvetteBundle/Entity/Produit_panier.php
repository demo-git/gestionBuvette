<?php

namespace BuvetteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit_panier
 *
 * @ORM\Table(name="produit_panier")
 * @ORM\Entity()
 */
class Produit_panier
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
     * @ORM\ManyToOne(targetEntity="Panier", inversedBy="produitCommandes")
     * @ORM\JoinColumn(name="panier_id", referencedColumnName="id")
     */
    private $panier;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Produit")
     * @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     */
    private $produit;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Operation", cascade={"all"}, orphanRemoval=true)
     */
    private $operation;
    
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
     * @return Produit_panier
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
     * Set panier
     *
     * @param \BuvetteBundle\Entity\Panier $panier
     *
     * @return Produit_panier
     */
    public function setPanier(\BuvetteBundle\Entity\Panier $panier = null)
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * Get panier
     *
     * @return \BuvetteBundle\Entity\Panier
     */
    public function getPanier()
    {
        return $this->panier;
    }

    /**
     * Set produit
     *
     * @param \UserBundle\Entity\Produit $produit
     *
     * @return Produit_panier
     */
    public function setProduit(\UserBundle\Entity\Produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \UserBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set operation
     *
     * @param \UserBundle\Entity\Operation $operation
     *
     * @return Produit_panier
     */
    public function setOperation(\UserBundle\Entity\Operation $operation = null)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return \UserBundle\Entity\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
