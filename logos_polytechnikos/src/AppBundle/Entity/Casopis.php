<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CasopisRepository")
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
     * @ORM\Column(type="string")
     */
    private $cislo;

    /**
     * @ORM\Column(type="string")
     */
    private $rocnik;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Prispevek", mappedBy="casopis")
     */
    private $prispevky;

	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	   * @ORM\JoinColumn(name="autor", referencedColumnName="id")
     */
    private $autor;

	 /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stav")
     * @ORM\JoinColumn(name="stav", referencedColumnName="id")
     */
    private $stav;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Nahrajte prosím soubor jako PDF")
     * @Assert\File(mimeTypes={"application/pdf"})
     */
    private $casopis;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tema")
     * @ORM\JoinTable(name="casopis_tema",
     *      joinColumns={@ORM\JoinColumn(name="casopis", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tema", referencedColumnName="id")}
     *      )
     */
    private $temata;

    public function __toString()
    {
        return $this->rok.'/Ročník '.$this->rocnik.'/Číslo '.$this->cislo;
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
     * Get rok
     *
     * @return string
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
     * @return string
     */
    public function getCislo()
    {
        return $this->cislo;
    }

	/**
     * Set cislo
     *
     * @return string
     */
    public function setCislo($cislo)
    {
        $this->cislo = $cislo;

		    return $this;
    }

    /**
       * Get rocnik
       *
       * @return string
       */
      public function getRocnik()
      {
          return $this->rocnik;
      }

    /**
       * Set rocnik
       *
       * @return string
       */
      public function setRocnik($rocnik)
      {
          $this->rocnik = $rocnik;

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

    /**
     * Get casopis
     *
     * @return string
     */
    public function getCasopis()
    {
        return $this->casopis;
    }

    /**
     * Set casopis
     *
     * @return string
     */
    public function setCasopis($casopis)
    {
        $this->casopis = $casopis;

        return $this;
    }

    /**
     * Add temata
     *
     * @param \RedakceBundle\Entity\Tema $temata
     *
     * @return Casopis
     */
    public function addTema(\AppBundle\Entity\Tema $tema)
    {
        $this->temata[] = $tema;

        return $this;
    }

    /**
     * Remove temata
     *
     * @param \AppBundle\Entity\Tema $temata
     */
    public function removeTema(\AppBundle\Entity\Tema $tema)
    {
        $this->temata->removeElement($tema);
    }

    /**
     * Get temata
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemata()
    {
        return $this->temata;
    }
}
