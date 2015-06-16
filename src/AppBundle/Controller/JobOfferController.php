<?php

namespace AppBundle\Controller;

use AppBundle\Entity\JobOffer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\JobOfferForm;

class JobOfferController extends Controller
{

    /**
     * @Route("/DodajOferte", name="nowaOferta")
     */
    public function addAction(Request $request)
    {
        $jobOffer = new JobOffer(); //nazwa encji
        $addForm = $this->createForm(new JobOfferForm(), $jobOffer); //nazwa klasy formularza

        $addForm->handleRequest($request); //sprawdza czy przyszly dane i umieszcza je w formularzu i w powiazanej encji
        if ($addForm->isValid()) {
            $interval = $addForm->get('howLong')->getData(); //pobierz wartosc pola howLong formularza
            
            $expiredAt = new \DateTime();
            $expiredAt->modify('+'.$interval.' days');
            
            $jobOffer->setExpiredAt($expiredAt);
            
            $this->getDoctrine()->getManager()->persist($jobOffer); //przygotowanie do trwalenia w DB
            $this->getDoctrine()->getManager()->flush(); //przesyła do DB
            
            $this->addFlash('success', 'Dodano ogloszenie :)');
            return $this->redirectToRoute('nowaOferta'); // bądź inna istniejąca routa
        }
        return $this->render('AppBundle:JobOfferForm:JobOfferForm.html.twig', array(
                    'twigform' => $addForm->createView(), //widok formularza przekazujemy do twiga
        ));
    }

}
