<?php

namespace AK\Bundle\WordLearnerBundle\Filter;

use AK\Bundle\WordLearnerBundle\Entity\Book;
use AK\Bundle\WordLearnerBundle\Entity\Chapter;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Class BookFilter
 * @package AK\Bundle\WordLearnerBundle\Filter
 */
class BookFilter extends SQLFilter
{

    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $alias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $alias)
    {
        $constraint = '';
        $entityName = $targetEntity->getName();
        $userId = $this->getParameter('user_id');

        switch ($entityName) {
            case Book::class:
                $constraint = $alias . '.id IN (SELECT book_id FROM users_books WHERE user_id = ' . $userId . ')';
                break;
            case Chapter::class:
                $constraint = $alias . '.book_id IN (SELECT book_id FROM users_books WHERE user_id = ' . $userId . ')';
                break;
            default:
                // No need to change the constraint
        }

        return $constraint;
    }
}
