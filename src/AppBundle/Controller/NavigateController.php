<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Model\Catalogues\GetCatalogueList;

class NavigateController extends Controller
{
    
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        return $this->render('docs/index.html.twig', array(
        ));
        
    } 
    
    /**
     * @Route("/navigate", name="navigate")
     */
    public function navigateAction(Request $request)
    {
        
        //get user
        $userGroupData = $this->get('security.token_storage')->getToken()->getUser();
        $userRoles = $this->get('security.token_storage')->getToken()->getUser()->getRoles();

        //get list of catalogues depend on user roles        
        $userRoles = $userRoles[0];
        
        //get catalogue list from main catalogue
        $getCatalogueList = new GetCatalogueList();

        $catalogueList = $getCatalogueList->getCatalogueList($this->em, $userGroupData, $userRoles, 0);
        
        return $this->render('docs/navigate.html.twig', array(
            'catalogueList' => $catalogueList,
        ));
        
    }
      
}
