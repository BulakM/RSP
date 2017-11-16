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
     * @ORM\Column(type="integer")
     */
    private $cislo;

    /**
     * @ORM\Column(type="integer")
     */
    private $rocnik;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uzaverka;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datumVytvoreni;

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

    public function __construct($autor, $stav)
    {
        $this->rocnik = (new \DateTime('now'))->format('y') - 9;
        $this->autor = $autor;
        $this->datumVytvoreni = new \DateTime('now');
        $this->stav = $stav;
        $this->temata = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
       * Get rocnik
       *
       * @return integer
       */
      public function getRocnik()
      {
          return $this->rocnik;
      }

    /**
       * Set rocnik
       *
       * @return integer
       */
      public function setRocnik($rocnik)
      {
          $this->rocnik = $rocnik;

          return $this;
      }

      /**
       * Set uzaverka
       *
       * @param \DateTime $uzaverka
       *
       * @return Casopis
       */
      public function setUzaverka($uzaverka)
      {
          $this->uzaverka = $uzaverka;

          return $this;
      }

      /**
       * Get uzaverka
       *
       * @return \DateTime
       */
      public function getUzaverka()
      {
          return $this->uzaverka;
      }

      /**
       * Set datumVytvoreni
       *
       * @param \DateTime $datumVytvoreni
       *
       * @return Casopis
       */
      public function setDatumVytvoreni($datumVytvoreni)
      {
          $this->datumVytvoreni = $datumVytvoreni;

          return $this;
      }

      /**
       * Get datumVytvoreni
       *
       * @return \DateTime
       */
      public function getDatumVytvoreni()
      {
          return $this->datumVytvoreni;
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
     * @param \AppBundle\Entity\Tema $temata
     *
     * @return Casopis
     */
    public function addTemata(\AppBundle\Entity\Tema $tema)
    {
        $this->temata[] = $tema;

        return $this;
    }

    /**
     * Remove temata
     *
     * @param \AppBundle\Entity\Tema $temata
     */
    public function removeTemata(\AppBundle\Entity\Tema $tema)
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
