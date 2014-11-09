<?php

namespace AK\Bundle\WordLearnerBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{
    public function getBooks()
    {
        $result = $this->findBy(array('id' => 1), array('title' => 'ASC'));

        return $result;
    }
} 
