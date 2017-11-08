<?php

namespace AppBundle\Entity;

/**
 * AppBundle\Entity\Uzivatel
 *
 * @ORM\Table()
 * 
 */
class Uzivatel
{
	/**
     * @ORM\Column(type="string")
     * @ORM\Login
     */
    private $login;
}

