<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Prispevatel
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
    private $email;

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
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

	/**
     * Set email
     * @param string $email
     * @return Prispevatel
     */
    public function setEmail($email)
    {
        $this->email = $email;
		return $this;
    }

}
