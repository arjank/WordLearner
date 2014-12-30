<?php

namespace AK\TwigExtensionsBundle\Twig;

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
     * @param Request|null $request
     */
    public function __construct(array $templates, Request $request = null)
    {
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

    /**
     * Returns the name of the template to use
     *
     * @return string
     */
    public function getParentTemplate()
    {
        $result = $this->templates['main'];
        if ($this->useAjaxTemplate()) {
            $result = $this->templates['ajax'];
        }

        return $result;
    }

    /**
     * @return bool
     */
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
