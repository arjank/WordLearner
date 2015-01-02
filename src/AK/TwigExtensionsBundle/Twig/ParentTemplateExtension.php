<?php

namespace AK\TwigExtensionsBundle\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

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
     */
    public function __construct(array $templates)
    {
        $this->templates = $templates;
    }

    /**
     * Sets the current request from the given request stack.
     *
     * @param RequestStack $requestStack
     */
    public function setRequest(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
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
