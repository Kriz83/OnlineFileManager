<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Model\Users\AddUserData;
use AppBundle\Model\Users\EditUserData;
use AppBundle\Model\Users\AddGroup;
use AppBundle\Model\Users\EditGroup;
use AppBundle\Model\Users\EnableUser;
use AppBundle\Model\Users\DisableUser;

use AppBundle\Form\User\AddGroupType;
use AppBundle\Form\User\AddUserDataType;
use AppBundle\Form\User\EditUserDataType;
use AppBundle\Form\User\EditGroupType;

class UsersController extends Controller
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
        
    /**
     * @Route("/showUsers", name="showUsers")
     */
    public function showUsersAction(Request $request)
    {
        //Retrive UserData data from db excluding admins      
        $userData = $this->em->getRepository('AppBundle:User')->getUsersWithData();

        return $this->render('docs/users/showUsers.html.twig', array(
            'userData' => $userData,
        ));
        
    }
        
    /**
     * @Route("/addUser", name="addUser")
     */
    public function addUserAction(Request $request)
    {
        
        $groupsNames = $this->em->getRepository('AppBundle:GroupName')->findAllData();
        
        $data = [];
        $data['groupsNames'] = $groupsNames;
        //create form
        $form = $this->get('form.factory')->createNamedBuilder('form', AddUserDataType::class, $data)
            ->getForm();

        $form->handleRequest($request);
        //

        if ($form->isSubmitted() && $form->isValid()) {  
            //add userData to db
            $addUserData = new AddUserData;
            $addUserData = $addUserData->setNewUserData($this->em, $form);

            //check if there are some errors and redirect
            switch($addUserData) {
                case 1:
                    $messageType = 'error';
                    $message = 'Nieprawidłowy adres E-mail!';
                    break;
                default:
                    $messageType = 'success';
                    $message = 'Dodano nowego Użytkownika!';
                    break;
            }

            $this->addFlash(
                $messageType,
                $message
            );

            //redirect only when user was added propertly
            if ($addUserData == null) {
                return $this->redirectToRoute('showUsers', array(
                )); 
            }
        }
        
        return $this->render('docs/users/addUser.html.twig', array(        
            'form' => $form->createView(),
        ));
        
    }   

    /**
     * @Route("/editUser/{userId}", name="editUser")
     */
    public function editUserAction(Request $request, $userId)
    {
        //get group names
        $groupsNames = $this->em->getRepository('AppBundle:GroupName')->findAllData();
        //get userData
        $userData = $this->em->getRepository('AppBundle:User')->findOneByUserId($userId);
        
        $data = [];
        $data['groupsNames'] = $groupsNames;
        $data['userData'] = $userData;
        //create form
        $form = $this->get('form.factory')->createNamedBuilder('form', EditUserDataType::class, $data)
            ->getForm();

        $form->handleRequest($request);
        //

        if ($form->isSubmitted() && $form->isValid()) {  
            //add userData to db
            $editUserData = new EditUserData;
            $editUserData = $editUserData->editUserData($this->em, $form, $userId);

            //check if there are some errors and redirect
            switch($editUserData) {
                case 1:
                    $messageType = 'error';
                    $message = 'Nieprawidłowy adres E-mail!';
                    break;
                case 2:
                    $messageType = 'error';
                    $message = 'Adres E-mail już istnieje!';
                    break;
                default:
                    $messageType = 'success';
                    $message = 'Edytowano dane Użytkownika!';
                    break;
            }

            $this->addFlash(
                $messageType,
                $message
            );

            //redirect only when user was added propertly
            if ($editUserData == null) {
                return $this->redirectToRoute('showUsers', array(
                )); 
            }
        }
        
        return $this->render('docs/users/editUser.html.twig', array(        
            'form' => $form->createView(),
        ));
        
    }
        
    /**
     * @Route("/addGroup", name="addGroup")
     */
    public function addGroupAction(Request $request)
    {
        //create form
        $form = $this->get('form.factory')->createNamedBuilder('form', AddGroupType::class)
            ->getForm();

        $form->handleRequest($request);
        //

        if ($form->isSubmitted() && $form->isValid()) {  
        
            $groupName = $form['name']->getData();
            //add groupName to db
            $addGroup = new AddGroup();
            $addGroup = $addGroup->addGroup($this->em, $groupName);

            //check if there are some errors and redirect
            switch($addGroup) {
                case 1:
                    $messageType = 'error';
                    $message = 'Grupa o tej nazwie już istnieje w bazie!';
                    break;
                default:
                    $messageType = 'success';
                    $message = 'Dodano nową Grupę!';
                    break;
            }

            $this->addFlash(
                $messageType,
                $message
            ); 

            //redirect only when user was added propertly
            if ($addGroup == null) {
                return $this->redirectToRoute('addGroup', array(
                )); 
            } 
        
        }
        //get all groupsNames to view
        $groupsData = $this->em->getRepository('AppBundle:GroupName')->findAll();

        return $this->render('docs/users/addGroup.html.twig', array(            
            'form' => $form->createView(),
            'groupsData' => $groupsData,
        ));
        
    }
        
    /**
     * @Route("/editGroup/{groupId}", name="editGroup")
     */
    public function editGroupAction(Request $request, $groupId)
    {
        //get group Data
        $groupData = $this->em->getRepository('AppBundle:GroupName')->findOneById($groupId);
        $currentGroupName = $groupData->getName();

        $data = [];
        $data['currentGroupName'] = $currentGroupName;

        //create form
        $form = $this->get('form.factory')->createNamedBuilder('form', EditGroupType::class, $data)
            ->getForm();

        $form->handleRequest($request);
        //

        if ($form->isSubmitted() && $form->isValid()) {  
        
            $groupName = $form['name']->getData();
            //add groupName to db
            $editGroup = new EditGroup();
            $editGroup = $editGroup->editGroup($this->em, $groupName, $currentGroupName, $groupData);

            //check if there are some errors and redirect
            switch($editGroup) {
                case 1:
                    $messageType = 'error';
                    $message = 'Grupa o tej nazwie już istnieje w bazie!';
                    break;
                default:
                    $messageType = 'success';
                    $message = 'Dodano nową Grupę!';
                    break;
            }

            $this->addFlash(
                $messageType,
                $message
            ); 

            //redirect only when user was added propertly
            if ($editGroup == null) {
                return $this->redirectToRoute('addGroup', array(
                )); 
            } 
        
        }

        return $this->render('docs/users/editGroup.html.twig', array(            
            'form' => $form->createView(),
            'groupId' => $groupId,
        ));
        
    }
       
    /**
     * @Route("/disableUser/{userId}", name="disableUser")
     */
    public function disableUserAction(Request $request, $userId)
    {
        
        //add userData to db
        $disableUser = new DisableUser;
        $disableUser = $disableUser->disableUser($this->em, $userId);

        return $this->redirectToRoute('showUsers', array(
        )); 

    }
    
    /**
     * @Route("/enableUser/{userId}", name="enableUser")
     */
    public function enableUserAction(Request $request, $userId)
    {
        
        //add userData to db
        $enableUser = new EnableUser;
        $enableUser = $enableUser->enableUser($this->em, $userId);

        return $this->redirectToRoute('showUsers', array(
        )); 

    }
      
      
}
