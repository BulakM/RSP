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
     * @ORM\Column(type="string")
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
     * @return integer
     */
    public function getRok()
    {
        return $this->rok;
    }

	/**
     * Set rok
     *
     * @return integer
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
