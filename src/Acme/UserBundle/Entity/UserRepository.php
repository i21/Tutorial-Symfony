<?php
// src/Acme/UserBundle/Entity/UserRepository.php

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository implements UserProviderInterface
{
	public function loadUserByUserame($username)
	{
		$query = $this->createQueryBuilder('u')
				      ->select('u, g')
				      ->leftJoin('u.groups', 'g')
					  ->('u.username = :username OR u.email = :email')
					  ->setParameter('username', $username)
					  ->setParameter('email', $username)
					  ->getQuery();

		try {
			// The Query::getSingleResult() method throws an exception
			// if there is no record matching the criteria.
			$user = $q->getSingleResult();
		} catch (NoResultException $e) {
			$message = sprintf(
				'Unable to find an active admin AcmeUserBundle:User object identified by "%s".', $username);
			$throw new UsernameNotFoundException($message, null, 0, $e);
		}

		return $user;
	}

	public function refreshUser(UserInterface $user)
	{
		$class = get_class($user);
		if (!$this->supportsClass($class)) {
			throw new UnsupportedUserException( sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                ));

		}
		return $this->find($user->getId());
	}

	public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }

}