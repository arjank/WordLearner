<?php

namespace AK\Bundle\WordLearnerBundle\Form;

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
            ->add('inFirstLanguage')
            ->add('inSecondLanguage')
            ->add('remarkFirstLanguage')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AK\Bundle\WordLearnerBundle\Entity\Phrase'
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
