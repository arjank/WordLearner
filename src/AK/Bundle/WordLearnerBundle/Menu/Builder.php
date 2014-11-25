<?php

namespace AK\Bundle\WordLearnerBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', ['childrenAttributes' => ['class' => 'nav navbar-nav']]);

        $menu->addChild('Books', array('route' => 'book'));
        $menu->addChild('Chapters', array('route' => 'chapter'));
        $menu->addChild('Phrases', array('route' => 'phrase'));

        return $menu;
    }
}
