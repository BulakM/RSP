<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 */
class Casopis
{
  	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $rok;

    /**
     * @ORM\Column(type="integer")
     */
    private $cislo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Prispevek", mappedBy="casopis")
     */
    private $prispevky;

	
	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="casopis")
	 * @ORM\JoinColumn(name="autor", referencedColumnName="id")
     */
    private $autor;
	
	 /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stav", inversedBy="prispevky")
     * @ORM\JoinColumn(name="stav", referencedColumnName="id")
     */
    private $stav;
	
	
	
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
     * Get rok
     *
     * @return date
     */
    public function getRok()
    {
        return $this->rok;
    }

	/**
     * Set rok
     *
     * @return Casopis
     */
    public function setRok($rok)
    {
        $this->rok = $rok;

		    return $this;
    }

	/**
     * Get cislo
     *
     * @return integer
     */
    public function getCislo()
    {
        return $this->cislo;
    }

	/**
     * Set cislo
     *
     * @return integer
     */
    public function setCislo($cislo)
    {
        $this->cislo = $cislo;

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
     * @return Casopis
     */
    public function setStav(\AppBundle\Entity\Stav $stav)
    {
        $this->stav = $stav;
        return $this;
    }
	
	/**
     * Get autor
     *
     * @return \AppBundle\Entity\User
     */
    public function getAutor()
    {
        return $this->autor;
    }
	
	/**
     * Set autor
     * @param \AppBundle\Entity\User $autor
     * @return Casopis
     */
    public function setAutor(\AppBundle\Entity\User $autor)
    {
        $this->autor = $autor;
        return $this;
    }
	
    /**
     * Add prispevky
     *
     * @param \AppBundle\Entity\Prispevek $prispevky
     *
     * @return Casopis
     */
    public function addPrispevek(\AppBundle\Entity\Prispevek $prispevek)
    {
        $this->prispevky[] = $prispevek;

        return $this;
    }

    /**
     * Remove prispevky
     *
     * @param \AppBundle\Entity\Prispevek $prispevky
     */
    public function removePrispevek(\AppBundle\Entity\Prispevek $prispevek)
    {
        $this->prispevky->removeElement($prispevek);
    }

    /**
     * Get prispevky
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrispevky()
    {
        return $this->prispevky;
    }
}
