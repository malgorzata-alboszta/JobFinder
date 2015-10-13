<?php

namespace AppBundle\Controller;

use AppBundle\Entity\JobOffer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\JobOfferForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class JobOfferController extends Controller
{

    /**
     * @Security("has_role('ROLE_ADMIN')")
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
            $expiredAt->modify('+' . $interval . ' days');

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

    /**
     * @Route("/lista/{id}", name="lista", defaults={"id" = false}, requirements={"id":"\d+"})
     * @ParamConverter("category", class="AppBundle:Category", options={"id" = "id"})
     */
    public function listAction(Request $request, Category $category=null)
    {
        $repository = $this->getDoctrine()
                ->getRepository('AppBundle:JobOffer');
        
        $JobQuery = $repository->getJobOfferQuery($category);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $JobQuery, $request->query->get('page',1),$this->getParameter('max_on_page')
                );
        
        $categoriesRepository = $this->getDoctrine()
                ->getRepository('AppBundle:Category');
        
        $categories = $categoriesRepository ->findAll();

        return $this->render('AppBundle:JobOffer:list.html.twig', array(
                    'lista_ofert' => $pagination, 
                    'category_list'=>$categories,
        ));//      return array('lista_ofert'=> $jobsList); kiedy mamy @Template()
    }

    /**
     * @Route("/details/{id}", name="szczegoly")
     */
    public function viewAction($id)
    {
        $oferta = $this->getDoctrine()
                        ->getRepository('AppBundle:JobOffer')->find($id);

        return $this->render('AppBundle:JobOffer:DetailsList.html.twig', array(
                    'details' => $oferta,
        ));
    }

}
