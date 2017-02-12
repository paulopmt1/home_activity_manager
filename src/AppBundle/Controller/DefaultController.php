<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Activity;
use AppBundle\Entity\UserSystemMakeActivity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller
{
    /**
     * @Route("/app", name="homepage")
     */
    public function app(Request $request)
    {
        return $this->render('default/home.html.twig');
    }
    
    /**
     * @Route("/customLogin")
     */
    public function login(Request $request)
    {
        return $this->render('default/login.html.twig');
    }
    
    /**
     * @Route("/getUserActivities")
     * @Security("is_granted('ROLE_USER')")
     */
    public function getUserActivities(Request $request)
    {
        $em = $this->getDoctrine()->getManager();        
        $userId = $this->getUser()->getId();
        
        $data = $em->createQuery(
                "SELECT usma.id, a.name, a.punctuation, usma.createdAt "
                . "FROM AppBundle:Activity a "
                . "JOIN AppBundle:UserSystemMakeActivity usma "
                    . "WITH usma.activity = a "
                . "JOIN usma.userSystem u "
                . "WHERE u.id = :userSystemId "
                . "ORDER BY usma.createdAt")
            ->setParameter('userSystemId', $userId)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        $jsonResponse = new JsonResponse();
        $jsonResponse->setData($data);
        
        return $jsonResponse;
    }
    
    /**
     * @Route("/getAllActivities")
     * @Security("is_granted('ROLE_USER')")
     */
    public function getAllActivities(Request $request)
    {
        $em = $this->getDoctrine()->getManager();        
        $userId = $this->getUser()->getId();
        
        $data = $em->createQuery(
                "SELECT a.id, a.name, a.punctuation, a.description "
                . "FROM AppBundle:Activity a "
                . "ORDER BY a.name")
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        $jsonResponse = new JsonResponse();
        $jsonResponse->setData($data);
        
        return $jsonResponse;
    }
    
    /**
     * @Route("/addActivity/{activity}")
     * @ParamConverter("activity", class="AppBundle:Activity")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addActivity(Activity $activity)
    {
        $em = $this->getDoctrine()->getManager();        
        $userId = $this->getUser()->getId();
        
        $userSystem = $em->getReference('AppBundle:UserSystem', $userId);
        
        $usma = new UserSystemMakeActivity();
        $usma->setActivity($activity);
        $usma->setUserSystem($userSystem);
        $usma->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $em->persist($usma);
        $em->flush();
        
        return new Response();
    }
    
    /**
     * @Route("/deleteUserActivity/{userActivity}")
     * @ParamConverter("userActivity", class="AppBundle:UserSystemMakeActivity")
     * @Security("is_granted('ROLE_USER')")
     */
    public function deleteUserActivity(UserSystemMakeActivity $userActivity)
    {
        $em = $this->getDoctrine()->getManager();        
        $em->remove($userActivity);
        $em->flush();
        
        return new Response();
    }
}
