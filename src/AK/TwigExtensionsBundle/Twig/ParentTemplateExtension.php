<?php

namespace AK\TwigExtensionsBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ParentTemplateExtension
 *
 * This class is inspired by the Twig Extension of Richard Miller
 * @see http://richardmiller.co.uk/2013/05/22/symfony2-yet-more-on-that-twig-extension/
 */
class ParentTemplateExtension extends \Twig_Extension
{
    /** @var Request */
    private $request;

    /** @var string[] */
    private $templates;

    /**
     * @param array $templates
     * @param ContainerInterface $container
     */
    public function __construct(array $templates, ContainerInterface $container)
    {
        $request = null;
        if ($container->has('request')) {
            $request = $container->get('request');
        }
        $this->request = $request;
        $this->templates = $templates;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('parent_template', [$this, 'getParentTemplate']),
        );
    }

    public function getParentTemplate()
    {
        $result = $this->templates['main'];
        if ($this->useAjaxTemplate()) {
            $result = $this->templates['ajax'];
        }

        return $result;
    }

    private function useAjaxTemplate()
    {
        $result = false;

        if ($this->request instanceof Request) {
            $result = $this->request->isXmlHttpRequest();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ak_parent_template';
    }
}
