<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/login")
     */
    public function login(Request $request)
    {
        return $this->render('default/login.html.twig');
    }
    
    /**
     * @Route("/getActivities")
     */
    public function getActivities(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = 1;
        
        $data = $em->createQuery(
                "SELECT a.id, a.name, a.punctuation "
                . "FROM AppBundle:Activity a "
                . "JOIN AppBundle:UserSystemMakeActivity usma "
                    . "WITH usma.activity = a "
                . "JOIN usma.userSystem u "
                . "WHERE u.id = :userSystemId")
            ->setParameter('userSystemId', $userId)
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        $jsonResponse = new JsonResponse();
        $jsonResponse->setData($data);
        
        return $jsonResponse;
    }
}
