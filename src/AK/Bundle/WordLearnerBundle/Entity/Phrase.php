<?php

namespace AK\Bundle\WordLearnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Phrase
 *
 * @ORM\Entity
 * @ORM\Table(name="phrase")
 */
class Phrase
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
     * @var Chapter
     *
     * @ORM\ManyToOne(targetEntity="Chapter", inversedBy="phrases")
     */
    private $chapter;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="in_first_language")
     */
    private $inFirstLanguage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="in_second_language")
     */
    private $inSecondLanguage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="remark_first_language")
     */
    private $remarkFirstLanguage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="remark_second_language")
     */
    private $remarkSecondLanguage;

    /**
     * @return Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * @param Chapter $chapter
     */
    public function setChapter($chapter)
    {
        $this->chapter = $chapter;
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
    public function getInFirstLanguage()
    {
        return $this->inFirstLanguage;
    }

    /**
     * @param string $inFirstLanguage
     */
    public function setInFirstLanguage($inFirstLanguage)
    {
        $this->inFirstLanguage = $inFirstLanguage;
    }

    /**
     * @return string
     */
    public function getInSecondLanguage()
    {
        return $this->inSecondLanguage;
    }

    /**
     * @param string $inSecondLanguage
     */
    public function setInSecondLanguage($inSecondLanguage)
    {
        $this->inSecondLanguage = $inSecondLanguage;
    }

    /**
     * @return string
     */
    public function getRemarkFirstLanguage()
    {
        return $this->remarkFirstLanguage;
    }

    /**
     * @param string $remarkFirstLanguage
     */
    public function setRemarkFirstLanguage($remarkFirstLanguage)
    {
        $this->remarkFirstLanguage = $remarkFirstLanguage;
    }

    /**
     * @return string
     */
    public function getRemarkSecondLanguage()
    {
        return $this->remarkSecondLanguage;
    }

    /**
     * @param string $remarkSecondLanguage
     */
    public function setRemarkSecondLanguage($remarkSecondLanguage)
    {
        $this->remarkSecondLanguage = $remarkSecondLanguage;
    }
}
