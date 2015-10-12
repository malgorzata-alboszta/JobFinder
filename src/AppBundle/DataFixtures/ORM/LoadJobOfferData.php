<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\JobOffer;


class LoadJobOfferData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('pl_PL');
        
        for ($j = 0; $j < 500; $j++){
        
        $job = new JobOffer();
        $job ->setPosition($faker->sentence(2));
        $job ->setLocation($faker->city());
        $job ->setCompanyName($faker->company());
        $job ->setType($faker->randomElement($array = array('ft','pt','f')));
        $job ->setLogo($faker->imageUrl($width=640, $height=480));
        $job ->setUrl($faker->url());
        $job ->setCategory($this->getReference('category'.$faker->numberBetween(1,10)));
        $job ->setDescription($faker->text());
        $job ->setHowToApply($faker->randomElement($array = array('email','applikacja internetowa','osobiscie')));
        $job ->setEmail($faker->email());
        $job ->setCreatedAt($faker->dateTimeBetween('-1 month', 'now'));
        
        $manager->persist($job);
        }
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 2; //the order in which fixtures will be loaded
    }
}
