<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobOfferForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('position', 'text', array('label' => 'Stanowisko'))
                ->add('location', 'text', array('label' => 'Lokalizacja'))
                ->add('companyName', 'text', array('label' => 'Firma'))
                ->add('type', 'choice', array(
                    'choices' => array('ft' => 'Full-time',
                        'pt' => 'Part-time', 'f' => 'freelance'),
                    'required' => false,
                    'label' => 'Wymiar Pracy'))
                ->add('logo', 'text', array('label' => 'Logo', 'required' => false))
                ->add('url', 'text', array('label' => 'Url', 'required' => false))
                ->add('category', 'entity', array(
                    'class' => 'AppBundle:Category',
                    'property' => 'category',
                ))
                //->add('category', 'text', array('label' => 'Kategoria'))
                ->add('description', 'textarea', array('label' => 'Opis'))
                ->add('howToApply', 'text', array('label' => 'Aplikowanie'))
                ->add('email', 'text', array('label' => 'Kontakt email'))
                ->add('howLong', 'integer', array('label' => 'Ilosc dni na portalu', 'mapped' => false, 'data' => 30))
                ->add('save', 'submit');
    }

    //The getName() method returns the identyfier of this form "type".
    public function getName()
    {
        return 'Job_offer';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\JobOffer',
//            'validation_groups' => array(''),
        ));
//        
//        if (true) {
//            $resolver->setDefault('validation_groups', array(''));
//        }
    }

}
