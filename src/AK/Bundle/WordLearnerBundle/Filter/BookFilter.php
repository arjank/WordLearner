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
        $entityName = $targetEntity->getName();
        // We cannot be sure that user_id has been set, so we cannot retrieve it here.

        switch ($entityName) {
            case Book::class:
                $userId = $this->getParameter('user_id');
                $constraint = $alias . '.id IN (SELECT book_id FROM users_books WHERE user_id = ' . $userId . ')';
                break;
            case Chapter::class:
                $userId = $this->getParameter('user_id');
                $constraint = $alias . '.book_id IN (SELECT book_id FROM users_books WHERE user_id = ' . $userId . ')';
                break;
            default:
                $constraint = '';
                break;
        }

        return $constraint;
    }
}
