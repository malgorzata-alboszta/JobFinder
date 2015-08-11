<?php

namespace AppBundle\Controller;

use AppBundle\Form\Model\Registration;
use AppBundle\Form\Type\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountCreate extends Controller
{

    /**
     * @Route("/register/create", name="register-create")
     * @param Request $request
     * @return type
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());
        
        $form->handleRequest($request);

        $registration = $form->getData(); 
        if ($form->isSubmitted()) {

            
            $email = $registration->getUser()->getEmail();
            $nameOfEmail = strstr($email, '@', true);
            $registration->getUser()->setUsername($nameOfEmail);
            
            $options = [
                'cost'=>12,
            ];
            $password= $registration->getUser()->getPassword();
            $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);
            $registration->getUser()->setPassword($hash_password);
            
//            we set ROLE_USER as default role in User entity constructor
//            $registration->getUser()->setRoles(array('ROLE_USER'));
         
        }

        if ($form->isValid()) {
            $em->persist($registration->getuser());
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render(
                        'AppBundle:Account:register.html.twig', array('formularz' => $form->createView()));
    }

}
