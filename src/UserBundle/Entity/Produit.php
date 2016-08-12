<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ProduitRepository")
 */
class Produit
{
    const TYPE_DRINK = 0;
    const TYPE_SANDWITCH = 1;
    const TYPE_SNACK = 2;
    const TYPE_PIZZA = 3;
    const TYPE_COMPOSANT = 4;

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
     * @var int
     *
     * @ORM\Column(name="isBillable", type="boolean")
     */
    private $isBillable;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="quantiteActuelle", type="integer", options={"default" = 0})
     */
    private $quantiteActuelle = 0;

    /**
     * temps de cuisson en minute
     * @var int
     *
     * @ORM\Column(name="cuisson", type="integer", options={"default" = 0})
     */
    private $cuisson = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="prixVente", type="float", nullable=true)
     */
    private $prixVente;

    /**
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean", options={"default" = true})
     */
    private $actif = true;

    /**
     * @ORM\OneToMany(targetEntity="Composant", mappedBy="produitCompose", cascade={"persist", "remove"})
     */
    private $composants;

    /**
     * @ORM\OneToMany(targetEntity="Facture", mappedBy="produit", cascade={"persist"})
     */
    private $factures;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Image", cascade={"all"}, orphanRemoval=true)
     */
    private $image;

    public function __construct()
    {
        $this->composants = new ArrayCollection();
        $this->factures = new ArrayCollection();
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
     * Add composant
     *
     * @param \UserBundle\Entity\Composant $composant
     *
     * @return Produit
     */
    public function addComposant(\UserBundle\Entity\Composant $composant)
    {
        $this->composants[] = $composant;

        return $this;
    }

    /**
     * Remove composant
     *
     * @param \UserBundle\Entity\Composant $composant
     */
    public function removeComposant(\UserBundle\Entity\Composant $composant)
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

    /**
     * Set quantiteActuelle
     *
     * @param integer $quantiteActuelle
     *
     * @return Produit
     */
    public function setQuantiteActuelle($quantiteActuelle)
    {
        $this->quantiteActuelle = $quantiteActuelle;

        return $this;
    }

    /**
     * Get quantiteActuelle
     *
     * @return integer
     */
    public function getQuantiteActuelle()
    {
        return $this->quantiteActuelle;
    }

    /**
     * Set prixVente
     *
     * @param float $prixVente
     *
     * @return Produit
     */
    public function setPrixVente($prixVente)
    {
        if($prixVente <= 0){
            $prixVente = null;
        }
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return float
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Produit
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Add facture
     *
     * @param \UserBundle\Entity\Facture $facture
     *
     * @return Produit
     */
    public function addFacture(\UserBundle\Entity\Facture $facture)
    {
        $this->factures[] = $facture;

        return $this;
    }

    /**
     * Remove facture
     *
     * @param \UserBundle\Entity\Facture $facture
     */
    public function removeFacture(\UserBundle\Entity\Facture $facture)
    {
        $this->factures->removeElement($facture);
    }

    /**
     * Get factures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactures()
    {
        return $this->factures;
    }

    /**
     * Set image
     *
     * @param \UserBundle\Entity\Image $image
     *
     * @return Produit
     */
    public function setImage(\UserBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \UserBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set cuisson
     *
     * @param integer $cuisson
     *
     * @return Produit
     */
    public function setCuisson($cuisson)
    {
        $this->cuisson = $cuisson;

        return $this;
    }

    /**
     * Get cuisson
     *
     * @return integer
     */
    public function getCuisson()
    {
        return $this->cuisson;
    }

    /**
     * Set isBillable
     *
     * @param boolean $isBillable
     *
     * @return Produit
     */
    public function setIsBillable($isBillable)
    {
        $this->isBillable = $isBillable;

        return $this;
    }

    /**
     * Get isBillable
     *
     * @return boolean
     */
    public function getIsBillable()
    {
        return $this->isBillable;
    }
}
