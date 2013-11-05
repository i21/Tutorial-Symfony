<?php
// src/Acme/UserBundle/Entity/User.php

namespace Acme\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

class User implements AdvancedUserInterface, \Serializable
{
	private $id;
	private $username;
	private $salt;
	private $password;
	private $email;
	private $isActive;
	private $groups;

	public function __construct()
	{
		$this->isActive = true;
		$this->salt = md5(uniqid(null, true));
		$this->groups = new ArrayCollection();
	}

	// UserInterface implementation
	public function getUsername()
	{
		return $this->username;
	}

	// UserInterface implementation
    public function getSalt()
    {
        return $this->salt;
    }

    // UserInterface implementation
    public function getPassword()
    {
        return $this->password;
    }

    // UserInterface implementation
    public function getRoles()
    {
        return $this->groups->toArray();
    }

    // UserInterface implementation
    public function eraseCredentials() {}

    // UserInterface implementation
    public function equals(UserInterface $user) {
    	return $this->id === $user->getId();
    }

    public function serialize(){
    	return serialize(array(
    		$this->id,
    		));
    }

    public function unserialize($serialized) {
    	list(
    		$this->id,) = unserialize($serialized);
    }

    // AdvancedUserInterface implementation
    public function isAccountNonExpired(){
    	return true;
    }

    // AdvancedUserInterface implementation
    public function isAccountNonLocked(){
    	return true;
    }

    // AdvancedUserInterface implementation
    public function isCredentialsNonExpired(){
    	return true;
    }

    // AdvancedUserInterface implementation
    public function isEnabled()
    {
    	return $this->isActive;
    }
}