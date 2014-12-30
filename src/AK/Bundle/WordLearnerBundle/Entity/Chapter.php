<?php

namespace AK\Bundle\WordLearnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Chapter
 *
 * @ORM\Entity
 * @ORM\Table(name="chapter")
 */
class Chapter
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="chapters")
     */
    private $book;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Phrase[]
     *
     * @ORM\OneToMany(targetEntity="Phrase", mappedBy="chapter")
     * @ORM\OrderBy({"id"="ASC"})
     */
    private $phrases;

    /**
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param Book $book
     */
    public function setBook($book)
    {
        $this->book = $book;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Phrase[]
     */
    public function getPhrases()
    {
        return $this->phrases;
    }

    /**
     * @param Phrase[] $phrases
     */
    public function setPhrases($phrases)
    {
        $this->phrases = $phrases;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
