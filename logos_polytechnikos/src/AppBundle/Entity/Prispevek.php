<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="PrispevekRepository")
 */
class Prispevek
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
     * @ORM\Column(type="string", unique=true)
     */
    protected $hash;

	/**
     * @ORM\Column(type="string")
     */
    private $nazev;

	/**
     * @ORM\Column(type="string")
     */
    private $text;

	/**
     * @ORM\Column(type="datetime")
     */
    private $datumVytvoreni;


	 /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stav")
     * @ORM\JoinColumn(name="stav", referencedColumnName="id")
     */
    private $stav;

	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Casopis", inversedBy="prispevky")
	 * @ORM\JoinColumn(name="casopis", referencedColumnName="id")
     */
    private $casopis;

	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tema")
     * @ORM\JoinColumn(name="tema", referencedColumnName="id")
     */
    private $tema;

	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prispevatel")
	 * @ORM\JoinColumn(name="prispevatel", referencedColumnName="id")
     */
    private $prispevatel;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recenze", mappedBy="prispevek")
     */
    private $recenze;

    public function __construct()
    {
        $this->datumVytvoreni = new \DateTime('now');
    }

	/**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

	/**
     * Set hash
     * @param string $hash
     * @return Prispevek
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
		return $this;
    }

	/**
     * Get nazev
     *
     * @return string
     */
    public function getNazev()
    {
        return $this->nazev;
    }

	/**
     * Set nazev
     * @param string $nazev
     * @return Prispevek
     */
    public function setNazev($nazev)
    {
        $this->nazev = $nazev;
		return $this;
    }

	/**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

	/**
     * Set text
     * @param string $text
     * @return Prispevek
     */
    public function setText($text)
    {
        $this->text = $text;
		return $this;
    }

	/**
     * Get datumVytvoreni
     *
     * @return integer
     */
    public function getDatumVytvoreni()
    {
        return $this->datumVytvoreni;
    }

	/**
     * Set datumVytvoreni
     * @param datetime $datumVytvoreni
     * @return Prispevek
     */
    public function setDatumVytvoreni($datumVytvoreni)
    {
        $this->datumVytvoreni = $datumVytvoreni;
		return $this;
    }


	/**
     * Get stav
     *
     * @return \AppBundle\Entity\Stav
     */
    public function getStav()
    {
        return $this->stav;
    }

	/**
     * Set stav
     * @param \AppBundle\Entity\Stav $stav
     * @return Prispevek
     */
    public function setStav(\AppBundle\Entity\Stav $stav)
    {
        $this->stav = $stav;
        return $this;
    }

	/**
     * Get casopis
     *
     * @return \AppBundle\Entity\Casopis
     */
    public function getCasopis()
    {
        return $this->casopis;
    }

	/**
     * Set casopis
     * @param \AppBundle\Entity\Casopis $casopis
     * @return Prispevek
     */
    public function setCasopis(\AppBundle\Entity\Casopis $casopis)
    {
        $this->casopis = $casopis;
        return $this;
    }

	/**
     * Get tema
     *
     * @return \AppBundle\Entity\Tema
     */
    public function getTema()
    {
        return $this->tema;
    }

	/**
     * Set tema
     * @param \AppBundle\Entity\Tema $tema
     * @return Prispevek
     */
    public function setTema(\AppBundle\Entity\Tema $tema)
    {
        $this->tema = $tema;
        return $this;
    }

	/**
     * Get prispevatel
     *
     * @return \AppBundle\Entity\Prispevatel
     */
    public function getPrispevatel()
    {
        return $this->prispevatel;
    }

	/**
     * Set prispevatel
     * @param \AppBundle\Entity\Prispevatel $prispevatel
     * @return Prispevek
     */
    public function setPrispevatel(\AppBundle\Entity\Prispevatel $prispevatel)
    {
        $this->prispevatel = $prispevatel;
        return $this;
    }

    /**
     * Add recenze
     *
     * @param \AppBundle\Entity\Recenze $recenze
     *
     * @return Prispevek
     */
    public function addRecenze(\AppBundle\Entity\Recenze $recenze)
    {
        $this->recenze[] = $recenze;

        return $this;
    }

    /**
     * Remove recenze
     *
     * @param \AppBundle\Entity\Recenze $recenze
     */
    public function removeRecenze(\AppBundle\Entity\Recenze $recenze)
    {
        $this->recenze->removeElement($recenze);
    }

    /**
     * Get recenze
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecenze()
    {
        return $this->recenze;
    }
}
