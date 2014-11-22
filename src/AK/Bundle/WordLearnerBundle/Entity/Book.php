<?php

namespace AK\Bundle\WordLearnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Book
 *
 * @ORM\Entity(repositoryClass="AK\Bundle\WordLearnerBundle\Repository\BookRepository")
 * @ORM\Table(name="book")
 */
class Book
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="first_language", type="string")
     */
    private $firstLanguage;

    /**
     * @var string
     *
     * @ORM\Column(name="second_language", type="string")
     */
    private $secondLanguage;

    /**
     * @var Chapter[]
     *
     * @ORM\OneToMany(targetEntity="Chapter", mappedBy="book")
     */
    private $chapters;

    /**
     * @return Chapter[]
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * @param Chapter[] $chapters
     */
    public function setChapters($chapters)
    {
        $this->chapters = $chapters;
    }

    /**
     * @return string
     */
    public function getFirstLanguage()
    {
        return $this->firstLanguage;
    }

    /**
     * @param string $firstLanguage
     */
    public function setFirstLanguage($firstLanguage)
    {
        $this->firstLanguage = $firstLanguage;
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

    /**
     * @return string
     */
    public function getSecondLanguage()
    {
        return $this->secondLanguage;
    }

    /**
     * @param string $secondLanguage
     */
    public function setSecondLanguage($secondLanguage)
    {
        $this->secondLanguage = $secondLanguage;
    }
}
