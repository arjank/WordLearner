<?php

namespace AK\Bundle\WordLearnerBundle\Filter;

use AK\Bundle\WordLearnerBundle\Entity\Book;
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

        if ($targetEntity->getName() === Book::class) {
            $userId = $this->getParameter('user_id');
            $constraint = $alias . '.id IN (SELECT book_id FROM users_books WHERE user_id = ' . $userId . ')';
        }

        return $constraint;
    }
}
