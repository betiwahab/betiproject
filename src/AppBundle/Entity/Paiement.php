<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaiementRepository")
 */
class Paiement
{
    /**
     * @ORM\ManyToOne(targetEntity="Fournisseur", inversedBy="paiements")
     * @ORM\JoinColumn(nullable=true)
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity="Exercice", inversedBy="paiements")
     * @ORM\JoinColumn(nullable=true)
     */
    private $exercice;

    /**
     * @ORM\ManyToOne(targetEntity="Encaissement", inversedBy="paiements")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $encaissement;

    /**
     * @ORM\OneToMany(targetEntity="RetenuePaie", mappedBy="paiement")
     */
    private $retenuepaies;

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
     * @ORM\Column(name="dateEPaiement", type="datetime", nullable=true, nullable=true)
     */
    private $dateEPaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="refCheque", type="string", length=255)
     */
    private $refCheque;

    /**
     * @var string
     *
     * @ORM\Column(name="refVirement", type="string", length=255)
     */
    private $refVirement;

    /**
     * @var string
     *
     * @ORM\Column(name="montantHt", type="decimal", precision=10, scale=2)
     */
    private $montantHt;

    /**
     * @var string
     *
     * @ORM\Column(name="montantTtc", type="decimal", precision=10, scale=2)
     */
    private $montantTtc;

    /**
     * @var string
     *
     * @ORM\Column(name="tvaRetenue", type="decimal", precision=10, scale=2)
     */
    private $tvaRetenue;

    /**
     * @var string
     *
     * @ORM\Column(name="aibRetenu", type="decimal", precision=10, scale=2)
     */
    private $aibRetenu;


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
     * Set refCheque
     *
     * @param string $refCheque
     *
     * @return Paiement
     */
    public function setRefCheque($refCheque)
    {
        $this->refCheque = $refCheque;

        return $this;
    }

    /**
     * Get refCheque
     *
     * @return string
     */
    public function getRefCheque()
    {
        return $this->refCheque;
    }

    /**
     * Set refVirement
     *
     * @param string $refVirement
     *
     * @return Paiement
     */
    public function setRefVirement($refVirement)
    {
        $this->refVirement = $refVirement;

        return $this;
    }

    /**
     * Get refVirement
     *
     * @return string
     */
    public function getRefVirement()
    {
        return $this->refVirement;
    }

    /**
     * Set montantHt
     *
     * @param string $montantHt
     *
     * @return Paiement
     */
    public function setMontantHt($montantHt)
    {
        $this->montantHt = $montantHt;

        return $this;
    }

    /**
     * Get montantHt
     *
     * @return string
     */
    public function getMontantHt()
    {
        return $this->montantHt;
    }

    /**
     * Set montantTtc
     *
     * @param string $montantTtc
     *
     * @return Paiement
     */
    public function setMontantTtc($montantTtc)
    {
        $this->montantTtc = $montantTtc;

        return $this;
    }

    /**
     * Get montantTtc
     *
     * @return string
     */
    public function getMontantTtc()
    {
        return $this->montantTtc;
    }

    /**
     * Set tvaRetenue
     *
     * @param string $tvaRetenue
     *
     * @return Paiement
     */
    public function setTvaRetenue($tvaRetenue)
    {
        $this->tvaRetenue = $tvaRetenue;

        return $this;
    }

    /**
     * Get tvaRetenue
     *
     * @return string
     */
    public function getTvaRetenue()
    {
        return $this->tvaRetenue;
    }

    /**
     * Set aibRetenu
     *
     * @param string $aibRetenu
     *
     * @return Paiement
     */
    public function setAibRetenu($aibRetenu)
    {
        $this->aibRetenu = $aibRetenu;

        return $this;
    }

    /**
     * Get aibRetenu
     *
     * @return string
     */
    public function getAibRetenu()
    {
        return $this->aibRetenu;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->retenuepaies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set encaissement
     *
     * @param \AppBundle\Entity\Encaissement $encaissement
     *
     * @return Paiement
     */
    public function setEncaissement(\AppBundle\Entity\Encaissement $encaissement = null)
    {
        $this->encaissement = $encaissement;

        return $this;
    }

    /**
     * Get encaissement
     *
     * @return \AppBundle\Entity\Encaissement
     */
    public function getEncaissement()
    {
        return $this->encaissement;
    }

    /**
     * Add retenuepaie
     *
     * @param \AppBundle\Entity\RetenuePaie $retenuepaie
     *
     * @return Paiement
     */
    public function addRetenuepaie(\AppBundle\Entity\RetenuePaie $retenuepaie)
    {
        $this->retenuepaies[] = $retenuepaie;

        return $this;
    }

    /**
     * Remove retenuepaie
     *
     * @param \AppBundle\Entity\RetenuePaie $retenuepaie
     */
    public function removeRetenuepaie(\AppBundle\Entity\RetenuePaie $retenuepaie)
    {
        $this->retenuepaies->removeElement($retenuepaie);
    }

    /**
     * Get retenuepaies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRetenuepaies()
    {
        return $this->retenuepaies;
    }

    /**
     * Set exercice
     *
     * @param \AppBundle\Entity\Exercice $exercice
     *
     * @return Paiement
     */
    public function setExercice(\AppBundle\Entity\Exercice $exercice = null)
    {
        $this->exercice = $exercice;

        return $this;
    }

    /**
     * Get exercice
     *
     * @return \AppBundle\Entity\Exercice
     */
    public function getExercice()
    {
        return $this->exercice;
    }

    /**
     * Set dateEPaiement
     *
     * @param \DateTime $dateEPaiement
     *
     * @return Paiement
     */
    public function setDateEPaiement($dateEPaiement)
    {
        $this->dateEPaiement = $dateEPaiement;

        return $this;
    }

    /**
     * Get dateEPaiement
     *
     * @return \DateTime
     */
    public function getDateEPaiement()
    {
        return $this->dateEPaiement;
    }

    /**
     * Set fournisseur
     *
     * @param \AppBundle\Entity\Fournisseur $fournisseur
     *
     * @return Paiement
     */
    public function setFournisseur(\AppBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \AppBundle\Entity\Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }
}