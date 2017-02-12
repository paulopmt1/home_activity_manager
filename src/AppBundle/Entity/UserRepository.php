<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

use Doctrine\ORM\EntityManager;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    
    private $em, $userCompany, $domain;
    
    public function __construct(EntityManager $em, $class) {
        parent::__construct($em, $class);
        $this->em = $em;
    }
    
    /**
     * @return AdvancedUserInterface
     */
    public function loadUserByUsername($username)
    {
        $a = 1;
//        $q = $this
//            ->createQueryBuilder('u')
//            ->where('u.username = :username OR u.email = :email')
//            ->setParameter('username', $username)
//            ->setParameter('email', $username)
//            ->getQuery();
//    
//        $users = $q->getResult();
//        
//        try {
//            
//            foreach ($users as $user) {
//                
//                $companyHasUser = $this->em->createQuery("SELECT chs "
//                        . "FROM PmtVctPhotoBookBundle:CompanyHasUserSystem chs "
//                        . "WHERE chs.company = :companyId "
//                            . "AND chs.userSystem = :userId"
//                        )
//                        ->setParameter("userId", $user)
//                        ->execute();
//                
//                $userSystem = $this->em->getRepository("PmtVctPhotoBookBundle:UserSystem")->find($user);
//                        
//                if ($companyHasUser || $userSystem->getIsAdmin()) {
//                    return $user;
//                }
//            }
//            
//        } catch (NoResultException $e) {
//            $message = sprintf(
//                'Unable to find an active admin PmtVctUserBundle:User object identified by "%s".',
//                $username
//            );
//            throw new UsernameNotFoundException();
//        }

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
}