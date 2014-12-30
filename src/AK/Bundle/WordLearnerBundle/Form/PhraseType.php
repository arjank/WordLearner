<?php

namespace AK\Bundle\WordLearnerBundle\Form;

use AK\Bundle\WordLearnerBundle\Entity\Chapter;
use AK\Bundle\WordLearnerBundle\Entity\Phrase;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhraseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $firstLanguage = null;
        $secondLanguage = null;

        /** @var Phrase $data */
        $data = $builder->getData();
        $chapter = $data->getChapter();

        if ($chapter instanceof Chapter) {
            $firstLanguage = $chapter->getBook()->getFirstLanguage();
            $secondLanguage = $chapter->getBook()->getSecondLanguage();
        }

        $builder
            ->add('chapter', 'entity', array(
                'class' => 'AKWordLearnerBundle:Chapter',
                'property' => 'title',
                'query_builder' => function(EntityRepository $repo) {
                    $qb = $repo->createQueryBuilder('chapter');
                    $qb->orderBy('chapter.title', 'ASC');
                    return $qb;
                }
            ))
            ->add('inFirstLanguage', null, ['label' => $firstLanguage])
            ->add('remarkFirstLanguage')
            ->add('inSecondLanguage', null, ['label' => $secondLanguage])
            ->add('remarkSecondLanguage')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Phrase::class
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ak_bundle_wordlearnerbundle_phrase';
    }
}
