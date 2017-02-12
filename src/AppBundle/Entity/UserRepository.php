<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\EntityManager;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    
    private $em, $userCompany, $domain;
    
    public function __construct(EntityManager $em, $class) {
        parent::__construct($em, $class);
        $this->em = $em;
    }
    
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }

    public function loadUserByUsername($username) {
        
    }

}