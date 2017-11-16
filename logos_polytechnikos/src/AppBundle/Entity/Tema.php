<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Tema
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
    private $nazev;

  /**
   * @ORM\Column(type="boolean")
   */
    private $aktivni;

    public function __construct()
    {
        $this->aktivni = 1;
    }

    public function __toString()
    {
        return $this->nazev;
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
     * @return Tema
     */
    public function setNazev($nazev)
    {
        $this->nazev = $nazev;
		return $this;
    }

    /**
     * Set aktivni
     *
     * @param boolean $aktivni
     * @return Tema
     */
    public function setAktivni($aktivni)
    {
        $this->aktivni = $aktivni;

        return $this;
    }

    /**
     * Get aktivni
     *
     * @return boolean
     */
    public function getAktivni()
    {
        return $this->aktivni;
    }
}
