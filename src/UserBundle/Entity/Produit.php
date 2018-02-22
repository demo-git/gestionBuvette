<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * différencie les produits dont les stocks se font par facture
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
     * @ORM\Column(name="quantiteActuelle", type="float", options={"default" = 0})
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
     * nombre de produit déclenchant une alerte warning
     * @var int
     *
     * @ORM\Column(name="warnThreshold", type="integer", options={"default" = -1})
     */
    private $warnThreshold = -1;

    /**
     * nombre de produit déclenchant une alerte danger
     * @var int
     *
     * @ORM\Column(name="dangerThreshold", type="integer", options={"default" = -1})
     */
    private $dangerThreshold = -1;

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
     * @var bool
     *
     * @ORM\Column(name="needSauce", type="boolean", options={"default" = false})
     */
    private $needSauce = false;

    /**
     * @ORM\OneToMany(targetEntity="Facture", mappedBy="produit", cascade={"persist"})
     */
    private $factures;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Image", cascade={"all"}, orphanRemoval=true)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createAt", type="datetime")
     */
    protected $createAt;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

    public function __construct()
    {
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
    public function addFacture(Facture $facture)
    {
        $this->factures[] = $facture;

        return $this;
    }

    /**
     * Remove facture
     *
     * @param \UserBundle\Entity\Facture $facture
     */
    public function removeFacture(Facture $facture)
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
    public function setImage(Image $image = null)
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

    /**
     * Set warnThreshold
     *
     * @param integer $warnThreshold
     *
     * @return Produit
     */
    public function setWarnThreshold($warnThreshold)
    {
        $this->warnThreshold = $warnThreshold;

        return $this;
    }

    /**
     * Get warnThreshold
     *
     * @return integer
     */
    public function getWarnThreshold()
    {
        return $this->warnThreshold;
    }

    /**
     * Set dangerThreshold
     *
     * @param integer $dangerThreshold
     *
     * @return Produit
     */
    public function setDangerThreshold($dangerThreshold)
    {
        $this->dangerThreshold = $dangerThreshold;

        return $this;
    }

    /**
     * Get dangerThreshold
     *
     * @return integer
     */
    public function getDangerThreshold()
    {
        return $this->dangerThreshold;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Produit
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Produit
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set needSauce
     *
     * @param boolean $needSauce
     *
     * @return Produit
     */
    public function setNeedSauce($needSauce)
    {
        $this->needSauce = $needSauce;

        return $this;
    }

    /**
     * Get needSauce
     *
     * @return boolean
     */
    public function getNeedSauce()
    {
        return $this->needSauce;
    }
}
