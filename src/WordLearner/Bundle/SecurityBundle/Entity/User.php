<?php

namespace WordLearner\Bundle\SecurityBundle\Entity;

use AK\Bundle\WordLearnerBundle\Entity\Book;
use Doctrine\ORM\PersistentCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Book[]
     *
     * @ORM\ManyToMany(targetEntity="AK\Bundle\WordLearnerBundle\Entity\Book")
     * @ORM\JoinTable(
     *      name="users_books",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")}
     * )
     */
    protected $books;

    /**
     * @return \AK\Bundle\WordLearnerBundle\Entity\Book[]|PersistentCollection
     */
    public function getBooks()
    {
        return $this->books;
    }
}
