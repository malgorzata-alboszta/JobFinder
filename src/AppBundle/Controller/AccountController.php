<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\RegistrationType;
use AppBundle\Form\Model\Registration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AccountController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @return type
     */

    public function registerAction()
    {
        $registration = new Registration(); 
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('register-create'),
        ));

        return $this->render(
                        'AppBundle:Account:register.html.twig', array('formularz' => $form->createView())
        );
    }

}
