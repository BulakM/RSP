<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use \Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    private $jmeno;

    /**
     * @ORM\Column(type="string")
     */
    private $prijmeni;

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set jmeno
     *
     * @param string $jmeno
     * @return User
     */
    public function setJmeno($jmeno)
    {
        $this->jmeno = $jmeno;

        return $this;
    }

    /**
     * Get jmeno
     *
     * @return string
     */
    public function getJmeno()
    {
        return $this->jmeno;
    }

    /**
     * Set prijmeni
     *
     * @param string $prijmeni
     *
     * @return User
     */
    public function setPrijmeni($prijmeni)
    {
        $this->prijmeni = $prijmeni;

        return $this;
    }

    /**
     * Get prijmeni
     *
     * @return string
     */
    public function getPrijmeni()
    {
        return $this->prijmeni;
    }
}
