<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Composant
 *
 * @ORM\Table(name="composant")
 * @ORM\Entity()
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
     * @ORM\Column(name="quantite", type="float", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumn(name="produit_composant_id", referencedColumnName="id")
     */
    private $produitComposant;

    /**
     * @ORM\ManyToOne(targetEntity="Produit", inversedBy="composants")
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
     * @param \UserBundle\Entity\Produit $produitComposant
     *
     * @return Composant
     */
    public function setProduitComposant(Produit $produitComposant = null)
    {
        $this->produitComposant = $produitComposant;

        return $this;
    }

    /**
     * Get produitComposant
     *
     * @return \UserBundle\Entity\Produit
     */
    public function getProduitComposant()
    {
        return $this->produitComposant;
    }

    /**
     * Set produitCompose
     *
     * @param \UserBundle\Entity\Produit $produitCompose
     *
     * @return Composant
     */
    public function setProduitCompose(Produit $produitCompose = null)
    {
        $this->produitCompose = $produitCompose;

        return $this;
    }

    /**
     * Get produitCompose
     *
     * @return \UserBundle\Entity\Produit
     */
    public function getProduitCompose()
    {
        return $this->produitCompose;
    }
}
