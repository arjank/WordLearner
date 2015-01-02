<?php

namespace AK\TwigExtensionsBundle\Tests\Twig;

use AK\TwigExtensionsBundle\Twig\ParentTemplateExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ParentTemplateExtensionTest
 * @coversDefaultClass AK\TwigExtensionsBundle\Twig\ParentTemplateExtension
 * @covers ::__construct
 * @covers ::<!public>
 */
class ParentTemplateExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ParentTemplateExtension */
    private $extension;

    /** @var Request|\PHPUnit_Framework_MockObject_MockObject */
    private $request;

    /** @var array */
    private $templates = array(
        'main' => 'main template',
        'ajax' => 'ajax template',
    );

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = $this->getMockRequest();
        $this->extension = new ParentTemplateExtension($this->templates);
    }

    /**
     * @test
     *
     * @param $isXmlHttpRequest
     * @param string $expected
     *
     * @covers ::getParentTemplate
     * @covers ::setRequest
     * @dataProvider providerForTemplateNames
     */
    public function extensionShouldReturnCorrectTemplateIfRequestIsSet($isXmlHttpRequest, $expected)
    {
        $extension = $this->extension;
        $request = $this->request;
        $stack = $this->getMockRequestStack($this->request);
        $extension->setRequest($stack);

        $request->expects($this->exactly(1))
            ->method('isXmlHttpRequest')
            ->willReturn($isXmlHttpRequest);

        $actual = $extension->getParentTemplate();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     *
     * @covers ::getParentTemplate
     * @covers ::setRequest
     */
    public function extensionShouldReturnMainTemplateIfCurrentRequestIsNull()
    {
        $extension = $this->extension;
        $requestStack = $this->getMockRequestStack(null);
        $extension->setRequest($requestStack);

        $actual = $extension->getParentTemplate();
        $expected = $this->templates['main'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     *
     * @covers ::getParentTemplate
     */
    public function extensionShouldReturnMainTemplateIfRequestIsNotSet()
    {
        $extension = $this->extension;

        $actual = $extension->getParentTemplate();
        $expected = $this->templates['main'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     *
     * @covers ::getName
     */
    public function extensionShouldReportCorrectName()
    {
        $extension = $this->extension;

        $expected = 'ak_parent_template';
        $actual = $extension->getName();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     *
     * @covers ::getFunctions
     */
    public function extensionShouldReportFunctions()
    {
        $extension = $this->extension;

        /** @var \Twig_SimpleFunction[] $functions */
        $functions = $extension->getFunctions();

        $this->assertCount(1, $functions);

        $expected = 'parent_template';
        $actual = $functions[0]->getName();
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function providerForTemplateNames()
    {
        return array(
            'ajax' => array(true, $this->templates['ajax']),
            'default' => array(false, $this->templates['main']),
        );
    }

    /**
     * @return Request|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRequest()
    {
        $mock = $this->getMockBuilder(Request::class)
            ->getMock();

        return $mock;
    }

    /**
     * @param Request|null $request
     *
     * @return RequestStack|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRequestStack(Request $request = null)
    {
        $mock = $this->getMockBuilder(RequestStack::class)->getMock();

        $mock->expects($this->any())
            ->method('getCurrentRequest')
            ->willReturn($request);

        return $mock;
    }
}
