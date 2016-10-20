<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity()
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
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createAt", type="datetime")
     */
    protected $createAt;

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
     * @param \BuvetteBundle\Entity\Produit_panier $produitCommande
     *
     * @return Panier
     */
    public function addProduitCommande(\UserBundle\Entity\Produit_panier $produitCommande)
    {
        $this->produitCommandes[] = $produitCommande;

        return $this;
    }

    /**
     * Remove produitCommande
     *
     * @param \BuvetteBundle\Entity\Produit_panier $produitCommande
     */
    public function removeProduitCommande(\UserBundle\Entity\Produit_panier $produitCommande)
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

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Panier
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }
}
