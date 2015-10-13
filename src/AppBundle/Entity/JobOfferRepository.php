<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Category;

class JobOfferRepository extends EntityRepository
{
    public function getJobOfferQuery(Category $category=null)    
    {
        $query = $this->createQueryBuilder('j')
                ->where('j.expiredAt> :now')
                ->setParameter('now', new \DateTime())
                ->orderBy('j.createdAt', 'ASC');
               
        if ($category) {
            $query
                    ->andWhere ('j.category = :category')
                    ->setParameter ('category', $category);
        }
        
        $query->getQuery();
        
        return $query;
    }       
    
}
