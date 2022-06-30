<?php

namespace Tests\Unit\CQ\Queries\Query;

use App\Interfaces\CQ\Queries\Query\CollectionQueryInterface;
use Tests\TestCase;

abstract class CollectionQueryTest extends TestCase
{
    public const MOCK_LIMIT = 1;
    public const MOCK_ORDER_BY = 'created_at';
    public const MOCK_SORT_ORDER = 'asc';

    protected CollectionQueryInterface $sut;

    protected abstract function getSutInstance(
        ?int $limit = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
    ): CollectionQueryInterface;

    public function testSutMethodsReturnDefaultValuesWhenNoParamsProvided(): void
    {
        $this->sut = $this->getSutInstance();

        $this->assertNull( $this->sut->getLimit() );
        $this->assertNull( $this->sut->getOrderBy() );
        $this->assertNull( $this->sut->getSortOrder() );
    }

    public function testSutHasExpectedMethods(): void
    {
        $this->sut = $this->getSutInstance();

        $this->assertTrue( method_exists( $this->sut, 'getLimit' ) );
        $this->assertTrue( method_exists( $this->sut, 'getOrderBy' ) );
        $this->assertTrue( method_exists( $this->sut, 'getSortOrder' ) );
    }

    public function testGetLimitReturnsValueProvidedInConstructor(): void
    {
        $this->sut = $this->getSutInstance( self::MOCK_LIMIT );

        $this->assertEquals( self::MOCK_LIMIT, $this->sut->getLimit() );
    }

    public function testGetOrderByReturnsValueProvidedInConstructor(): void
    {
        $this->sut = $this->getSutInstance(
            self::MOCK_LIMIT,
            self::MOCK_ORDER_BY
        );

        $this->assertEquals( self::MOCK_ORDER_BY, $this->sut->getOrderBy() );
    }

    public function testGetSortOrderReturnsValueProvidedInConstructor(): void
    {
        $this->sut = $this->getSutInstance(
            self::MOCK_LIMIT,
            self::MOCK_ORDER_BY,
            self::MOCK_SORT_ORDER
        );

        $this->assertEquals( self::MOCK_SORT_ORDER, $this->sut->getSortOrder() );
    }

}
