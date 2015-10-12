<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categoriesName = [
            'Administracja biurowa',
            'Public Relations',
            'Reklama/Grafika/Kreacja/Fotografia',
            'Sektor publiczny',
            'Sprzedaz',
            'Transport/Spedycja',
            'Ubezpieczenia',
            'Zakupy',
            'Zdrowie/Uroda/Rekreacja',
            'inne'
        ];
          
        $i=1;
        foreach ($categoriesName as $categoryName){
            $category =new Category();
            $category->setCategory($categoryName);
            $this->addReference('category'.$i++, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
    public function getOrder()
    {
        return 1; //the order  in which fixtures will be loaded
    }
}

    
