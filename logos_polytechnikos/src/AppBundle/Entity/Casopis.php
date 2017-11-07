<?php

namespace AppBundle\Entity;

/**
 * AppBundle\Entity\Casopis
 *
 * @ORM\Table()
 * 
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
	
	/**
     * @ORM\Column(type="integer")
     * @ORM\Rok
     */
    private $rok
	
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
     * @ORM\Column(type="integer")
     * @ORM\Cislo
     */
    private $cislo
	
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prispevek")
     * @ORM\JoinColumn(name="casopisId", referencedColumnName="id")
     */
    private $casopisId;
}

