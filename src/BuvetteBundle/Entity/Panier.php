<?php

namespace BuvetteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\Operation;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity()
 */
class Panier
{
    const PAYEMENT_CB = 1;
    const PAYEMENT_LIQUIDE = 2;
    const PAYEMENT_AUTRE = 3;
    const PAYEMENT_STAFF = 4;

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
     * @ORM\Column(name="typePayement", type="integer")
     */
    private $typePayement;

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

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Operation", cascade={"all"}, orphanRemoval=true)
     */
    private $operation;

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
     * @return Panier
     */
    public function addProduitCommande(Produit_panier $produitCommande)
    {
        $this->produitCommandes[] = $produitCommande;

        return $this;
    }

    /**
     * Remove produitCommande
     *
     * @param \BuvetteBundle\Entity\Produit_panier $produitCommande
     */
    public function removeProduitCommande(Produit_panier $produitCommande)
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

    /**
     * Set typePayement
     *
     * @param integer $typePayement
     *
     * @return Panier
     */
    public function setTypePayement($typePayement)
    {
        $this->typePayement = $typePayement;

        return $this;
    }

    /**
     * Get typePayement
     *
     * @return integer
     */
    public function getTypePayement()
    {
        return $this->typePayement;
    }

    /**
     * Set operation
     *
     * @param \UserBundle\Entity\Operation $operation
     *
     * @return Panier
     */
    public function setOperation(Operation $operation = null)
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
