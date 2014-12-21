<?php

namespace AK\Bundle\WordLearnerBundle\Form;

use AK\Bundle\WordLearnerBundle\Repository\BookRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChapterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('book', 'entity', [
                'class' => 'AKWordLearnerBundle:Book',
                'property' => 'title',
                'query_builder' => function(BookRepository $repo) {
                    $qb = $repo->createQueryBuilder('book');
//                    $qb->select('book.id, book.title');
                    $qb->orderBy('book.title', 'ASC');
                    return $qb;
                }
            ])
            ->add('title')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AK\Bundle\WordLearnerBundle\Entity\Chapter'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ak_bundle_wordlearnerbundle_chapter';
    }
}
