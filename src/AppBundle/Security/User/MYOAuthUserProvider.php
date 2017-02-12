<?php

namespace AppBundle\Security\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use AppBundle\Entity\User;
use AppBundle\Entity\UserSystem;
use AppBundle\Entity\SocialLoginId;

class MYOAuthUserProvider extends OAuthUserProvider {
    
    private $em, $userCompany;
    
    public function __construct(EntityManager $entityManager) {
        $this->em               = $entityManager;
    }
    
    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {

        $responseData = $response->getResponse();
        $socialNetwork = $response->getResourceOwner()->getName();
        
        $this->validateSocialData($responseData, $socialNetwork);
        
        return $this->loadUserBySocialId($socialNetwork, $responseData['id'], $responseData['name']);
    }
    
    private function validateSocialData($responseData, $serviceName){
        
        if (isset($responseData['error'])){
            throw new AccountNotLinkedException($responseData['error']['message']);
        }
        
        if ( ! in_array($serviceName, ['facebook','google'])){
            throw new \Exception('O servi�o ' . $serviceName . ' n�o est� configurado ainda');
        }
        
        if ( ! isset($responseData['name']) || ! isset($responseData['id'])){
            throw new \Exception("Faltando parametros do facebook. S� recebi isso: " . json_encode($responseData));
        }
    }
    
    private function createUserSystemForSocialMediaWithEmail($name, $useremail){
        $repo = $this->em->getRepository("PmtVctUserBundle:User");
        
        $user = $this->userCompany->createUserSystem($name, $useremail, $useremail);
        $this->userCompany->associateUserWithCompany($user, $repo->getSystemCompany(), true);
        $this->em->flush();
        
        return $user;
    }
    
    private function createUserSystemForSocialMediaWithSocialId($socialNetwork, $socialUserId, $name){
        $user = new UserSystem();
        $user->setName($name);
        $this->em->persist($user);
        
        $socialLoginId = new SocialLoginId();
        $socialLoginId->setSocialNetwork($socialNetwork);
        $socialLoginId->setSocialUserId($socialUserId);
        $socialLoginId->setUserSystem($user);
        
        $this->em->persist($socialLoginId);
        
        $this->em->flush();
        
        return $user;
    }
    
    private function loadUserBySocialId($socialNetwork, $socialUserId, $name){
        
        $socialUser = $this->em->getRepository("AppBundle:SocialLoginId")->findOneBy([
            'socialNetwork' => $socialNetwork,
            'socialUserId'  => $socialUserId
        ]);
        
        if ($socialUser){
            $user = $socialUser->getUserSystem();
            return $this->createUserInterfaceInstance($user->getId(), $user->getName());
        }
        
        $newUserSystem = $this->createUserSystemForSocialMediaWithSocialId($socialNetwork, $socialUserId, $name);
        return $this->createUserInterfaceInstance($newUserSystem->getId(), $name);
        
    }
    
    private function createUserInterfaceInstance($aurynId, $name){
        $user = new User();
        $user->setIsActive(true);
        $user->setName($name);
        $user->setUserId($aurynId);
        
        return $user;
    }
    
}
