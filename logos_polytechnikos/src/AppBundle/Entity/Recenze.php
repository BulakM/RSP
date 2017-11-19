<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RecenzeRepository")
 */
class Recenze
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
     * @ORM\Column(type="integer")
     */
    private $odbornost;

	/**
     * @ORM\Column(type="integer")
     */
    private $zajimavost;

	/**
     * @ORM\Column(type="integer")
     */
    private $aktualnost;

	/**
     * @ORM\Column(type="string")
     */
    private $text;

    /**
       * @ORM\Column(type="datetime")
       */
      private $datumVytvoreni;

  	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
  	  * @ORM\JoinColumn(name="autor", referencedColumnName="id")
     */
    private $autor;

  	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prispevek", inversedBy="recenze")
  	  * @ORM\JoinColumn(name="prispevek", referencedColumnName="id")
     */
    private $prispevek;

    public function __construct($autor, $prispevek)
    {
        $this->autor = $autor;
        $this->prispevek = $prispevek;
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
     * Get odbornost
     *
     * @return integer
     */
    public function getOdbornost()
    {
        return $this->odbornost;
    }

	/**
     * Set odbornost
     * @param integer $odbornost
     * @return Recenze
     */
    public function setOdbornost($odbornost)
    {
        $this->odbornost = $odbornost;
		return $this;
    }

	/**
     * Get zajimavost
     *
     * @return integer
     */
    public function getZajimavost()
    {
        return $this->zajimavost;
    }

	/**
     * Set zajimavost
     * @param integer $zajimavost
     * @return Recenze
     */
    public function setZajimavost($zajimavost)
    {
        $this->zajimavost = $zajimavost;
		return $this;
    }

	/**
     * Get aktualnost
     *
     * @return integer
     */
    public function getAktualnost()
    {
        return $this->aktualnost;
    }

	/**
     * Set aktualnost
     * @param integer $aktualnost
     * @return Recenze
     */
    public function setAktualnost($aktualnost)
    {
        $this->aktualnost = $aktualnost;
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
     * @return Recenze
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
     * @return Recenze
     */
    public function setDatumVytvoreni($datumVytvoreni)
    {
        $this->datumVytvoreni = $datumVytvoreni;

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
     * @return Recenze
     */
    public function setAutor(\AppBundle\Entity\User $autor)
    {
        $this->autor = $autor;
        return $this;
    }

	/**
     * Get prispevek
     *
     * @return AppBundle\Entity\Prispevek
     */
    public function getPrispevek()
    {
        return $this->prispevek;
    }

	/**
     * Set prispevek
     * @param AppBundle\Entity\Prispevek $prispevek
     * @return Recenze
     */
    public function setPrispevek(AppBundle\Entity\Prispevek $prispevek)
    {
        $this->prispevek = $prispevek;
        return $this;
    }
}
