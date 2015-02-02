<?php

namespace AK\Bundle\WordLearnerBundle\Controller;

use AK\Bundle\WordLearnerBundle\Entity\Chapter;
use AK\Bundle\WordLearnerBundle\Entity\Phrase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class QuizController
 * @Route("/quiz")
 */
class QuizController extends Controller
{
    /**
     * @param Chapter $chapter
     * @param bool $reversed
     *
     * @Route("/{id}/{reversed}", name="quiz")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Chapter $chapter, $reversed)
    {

    }

    /**
     * @param Chapter $chapter
     * @param bool $reversed
     *
     * @return JsonResponse
     *
     * @Route("/phrases/{id}/{reversed}", name="quiz_phrases")
     * @Method({"GET"})
     */
    public function phrasesAction(Chapter $chapter, $reversed = false)
    {
        $phrases = $chapter->getPhrases();

        $result = $this->parsePhrases($phrases, $reversed);

        return new JsonResponse($result);
    }

    /**
     * @param Phrase[] $phrases
     * @param bool $reversed
     *
     * @return array
     */
    private function parsePhrases($phrases, $reversed)
    {
        $result = [];

        foreach ($phrases as $phrase) {
            if ($reversed) {
                $item = $this->getReversedItemFromPhrase($phrase);
            } else {
                $item = $this->getItemFromPhrase($phrase);
            }

            $result[] = $item;
        }

        shuffle($result);

        return $result;
    }

    /**
     * @param Phrase $phrase
     *
     * @return array
     */
    private function getItemFromPhrase(Phrase $phrase)
    {
        $item['question'] = $phrase->getInFirstLanguage();
        $item['answer'] = $phrase->getInSecondLanguage();
        $item['remark'] = $phrase->getRemarkSecondLanguage();

        return $item;
    }

    /**
     * @param Phrase $phrase
     *
     * @return array
     */
    private function getReversedItemFromPhrase(Phrase $phrase)
    {
        $item['question'] = $phrase->getInSecondLanguage();
        $item['answer'] = $phrase->getInFirstLanguage();
        $item['remark'] = $phrase->getRemarkFirstLanguage();

        return $item;
    }
}
