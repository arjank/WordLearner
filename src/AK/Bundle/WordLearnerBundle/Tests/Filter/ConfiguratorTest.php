<?php

namespace AK\Bundle\WordLearnerBundle\Tests\Filter;

use AK\Bundle\WordLearnerBundle\Filter\Configurator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\FilterCollection;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use WordLearner\Bundle\SecurityBundle\Entity\User;

/**
 * Class ConfiguratorTest
 *
 * @coversDefaultClass AK\Bundle\WordLearnerBundle\Filter\Configurator
 * @covers ::<!public>
 * @covers ::__construct
 */
class ConfiguratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Configurator */
    private $configurator;
    /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject */
    private $entityManager;
    /** @var SecurityContextInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $securityContext;
    /** @var FilterCollection|\PHPUnit_Framework_MockObject_MockObject */
    private $filterCollection;

    protected function setUp()
    {
        $mockEntityManager = $this->getMockEntityManager();
        $mockSecurityContext = $this->getMockSecurityContext();

        $this->configurator = new Configurator($mockEntityManager, $mockSecurityContext);
        $this->entityManager = $mockEntityManager;
        $this->securityContext = $mockSecurityContext;
    }

    /**
     * @test
     * @covers ::onKernelRequest
     */
    public function configuratorShouldKeepBookFilterForSuperAdminDisabled()
    {
        $configurator = $this->configurator;
        $filterCollection = $this->filterCollection;

        $securityContext = $this->securityContext;
        $token = $this->getMockToken();
        $userId = 10;
        $user = $this->getMockUser($userId);

        $token->expects($this->exactly(1))
            ->method('getUser')
            ->will($this->returnValue($user));
        $securityContext->expects($this->exactly(1))
            ->method('getToken')
            ->will($this->returnValue($token));
        $securityContext->expects($this->exactly(1))
            ->method('isGranted')
            ->with('ROLE_SUPER_ADMIN')
            ->will($this->returnValue(true));

        $filterCollection->expects($this->exactly(0))
            ->method('enable');

        $configurator->onKernelRequest();
    }

    /**
     * @test
     * @covers ::onKernelRequest
     */
    public function configuratorShouldEnableBookFilterForUser()
    {
        $configurator = $this->configurator;
        $entityManager = $this->entityManager;

        $securityContext = $this->securityContext;
        $token = $this->getMockToken();
        $userId = 5;
        $user = $this->getMockUser($userId);
        $filterCollection = $this->filterCollection;
        $filter = $this->getMockFilter($entityManager);

        $token->expects($this->exactly(1))
            ->method('getUser')
            ->will($this->returnValue($user));
        $securityContext->expects($this->exactly(1))
            ->method('getToken')
            ->will($this->returnValue($token));
        $securityContext->expects($this->exactly(1))
            ->method('isGranted')
            ->with('ROLE_SUPER_ADMIN')
            ->will($this->returnValue(false));

        $filterCollection->expects($this->exactly(1))
            ->method('enable')
            ->with(Configurator::FILTER_BOOK_FILTER)
            ->will($this->returnValue($filter));

        $configurator->onKernelRequest();
    }

    /**
     * @test
     * @covers ::onKernelRequest
     */
    public function configuratorShouldEnableBookFilterForAnonymousUser()
    {
        $configurator = $this->configurator;
        $entityManager = $this->entityManager;

        $securityContext = $this->securityContext;
        $token = $this->getMockToken();
        $userId = 5;
        $user = $this->getMockUser($userId);
        $filterCollection = $this->filterCollection;
        $filter = $this->getMockFilter($entityManager);

        $token->expects($this->exactly(1))
            ->method('getUser')
            ->will($this->returnValue(null));
        $securityContext->expects($this->exactly(1))
            ->method('getToken')
            ->will($this->returnValue($token));
        $securityContext->expects($this->any())
            ->method('isGranted')
            ->with('ROLE_SUPER_ADMIN')
            ->will($this->returnValue(false));

        $filterCollection->expects($this->exactly(1))
            ->method('enable')
            ->with(Configurator::FILTER_BOOK_FILTER)
            ->will($this->returnValue($filter));

        $configurator->onKernelRequest();
    }

    /**
     * @return EntityManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockEntityManager()
    {
        $mock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filters = $this->getMockFilterCollection($mock);
        $this->filterCollection = $filters;

        $mock->expects($this->any())->method('getFilters')->will($this->returnValue($filters));

        return $mock;
    }

    /**
     * @return SecurityContextInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockSecurityContext()
    {
        $mock = $this->getMockBuilder(SecurityContextInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getToken', 'isGranted'))
            ->getMockForAbstractClass();
//
//        $token = $this->getMockToken();
//
//        $mock->expects($this->exactly(1))->method('getToken')->will($this->returnValue($token));

        return $mock;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @return FilterCollection|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockFilterCollection(EntityManager $entityManager)
    {
        $mock = $this->getMockBuilder(FilterCollection::class)
            ->setConstructorArgs(array($entityManager))
            ->getMock();

        return $mock;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @return SQLFilter|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockFilter(EntityManager $entityManager)
    {
        $mock = $this->getMockBuilder(SQLFilter::class)
            ->setConstructorArgs(array($entityManager))
            ->getMockForAbstractClass();

        return $mock;
    }


    /**
     * @return TokenInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockToken()
    {
        $mock = $this->getMockBuilder(TokenInterface::class)
            ->setMethods(array('getUser'))
            ->getMockForAbstractClass();

        return $mock;
    }

    /**
     * @param int $id
     *
     * @return User|\PHPUnit_Framework_MockObject_MockBuilder
     */
    private function getMockUser($id)
    {
        $mock = $this->getMockBuilder(User::class)
            ->setMethods(array('getId'))
            ->getMock();

        $mock->expects($this->any())->method('getId')->will($this->returnValue($id));

        return $mock;
    }
}
