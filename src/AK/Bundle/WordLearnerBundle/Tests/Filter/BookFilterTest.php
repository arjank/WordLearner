<?php
/**
 * Created by PhpStorm.
 * User: arjan
 * Date: 2014-11-21
 * Time: 23:59
 */

namespace AK\Bundle\WordLearnerBundle\Tests\Filter;

use AK\Bundle\WordLearnerBundle\Entity\Book;
use AK\Bundle\WordLearnerBundle\Filter\BookFilter;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\FilterCollection;

/**
 * @coversDefaultClass AK\Bundle\WordLearnerBundle\Filter\BookFilter
 * @covers ::<!public>
 */
class BookFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var BookFilter */
    private $filter;
    /** @var EntityManager */
    private $entityManager;

    protected function setup()
    {
        $entityManager = $this->getMockEntityManager();
        $this->entityManager = $entityManager;

        $this->filter = new BookFilter($entityManager);
    }

    /**
     * @test
     * @covers ::addFilterConstraint
     */
    public function bookFilterShouldOnlyReturnFilterForBook()
    {
        $filter = $this->filter;
        $expected = '';

        $meta = $this->getMockClassMetadata('Foo');

        $actual = $filter->addFilterConstraint($meta, 'bar');

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @covers ::addFilterConstraint
     */
    public function bookFilterShouldReturnFilterForBook()
    {
        $filter = $this->filter;
        $alias = 'foo';
        $userId = 123;

        $expected = sprintf('%s.id IN (SELECT book_id FROM users_books WHERE user_id = %s)', $alias, $userId);

        $filter->setParameter('user_id', $userId);

        $meta = $this->getMockClassMetadata(Book::class);

        $actual = $filter->addFilterConstraint($meta, $alias);

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @covers ::addFilterConstraint
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage user_id
     */
    public function bookFilterShouldOnlyReturnFilterForBookWhenUserIdIsSet()
    {
        $filter = $this->filter;
        $alias = 'foo';

        $meta = $this->getMockClassMetadata(Book::class);

        $filter->addFilterConstraint($meta, $alias);
    }

    /**
     * @return EntityManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockEntityManager()
    {
        $mock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getFilters', 'getConnection'))
            ->getMock();

        $filters = $this->getMockFilterCollection($mock);
        $connection = $this->getMockConnection();

        $mock->expects($this->any())->method('getFilters')->will($this->returnValue($filters));
        $mock->expects($this->any())->method('getConnection')->will($this->returnValue($connection));

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

    private function getMockConnection()
    {
        $mock = $this->getMockBuilder(Connection::class)
            ->setMethods(array('quote'))
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())->method('quote')->willReturnArgument(0);

        return $mock;
    }

    /**
     * @return ClassMetadata|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockClassMetadata($className)
    {
        $mock = $this->getMockBuilder(ClassMetadata::class)
            ->setConstructorArgs(array($className))
            ->setMethods(null)
            ->getMock();

        return $mock;
    }
}
