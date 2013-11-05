<?php 
// src/Acme/UserBundle/Entity/Group.php

namespace Acme\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\Role;
use Doctrine\Common\Collections\ArrayCollection;

class Group extends Role
{
	private $id;
	private $name;
	private $role;
	private $users;

	public function __construct(){
		$this->users = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name)
	{
		$this->id = $name;
	}

	public function getRole() {
		return $this->role;
	}

	public function setRole($role)
	{
		$this->id = $role;
	}
}