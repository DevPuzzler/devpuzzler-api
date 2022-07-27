<?php

namespace Tests\Unit\CQ\Queries\Query\BlogPost;

use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQueryQuery;
use Tests\Unit\CQ\Queries\Query\CollectionQueryTest;

class GetBlogPostCollectionQueryTest extends CollectionQueryTest
{
    public const MOCK_CATEGORY_ID = 123;

    public function testSutMethodsReturnDefaultValuesWhenNoParamsProvided(): void
    {
        $this->sut = $this->getSutInstance();

        parent::testSutMethodsReturnDefaultValuesWhenNoParamsProvided();
        $this->assertFalse( $this->sut->getIsIncludeCategory() );
    }

    public function testSutHasExpectedMethods(): void
    {
        $this->sut = $this->getSutInstance();

        parent::testSutHasExpectedMethods();
        $this->assertTrue( method_exists( $this->sut, 'getIsIncludeCategory' ) );
    }

    public function testGetIsIncludeCategoryReturnsValueProvidedInConstructor(): void
    {
        $this->sut = $this->getSutInstance(
            self::MOCK_LIMIT,
            self::MOCK_OFFSET,
            self::MOCK_ORDER_BY,
            self::MOCK_SORT_ORDER,
            true
        );

        $this->assertTrue( $this->sut->getIsIncludeCategory() );
    }

    public function testGetCategoryIdReturnsValueProvidedInConstructor(): void
    {
        $this->sut = $this->getSutInstance(
            self::MOCK_LIMIT,
            self::MOCK_OFFSET,
            self::MOCK_ORDER_BY,
            self::MOCK_SORT_ORDER,
            true,
            self::MOCK_CATEGORY_ID,
        );

        $this->assertTrue( $this->sut->getIsIncludeCategory() );
    }

    public function testGetCategoryIdReturnsNullWhenNoValueInConstructor(): void
    {
        $this->sut = $this->getSutInstance();

        $this->assertNull( $this->sut->getCategoryId() );
    }

    protected function getSutInstance(
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
        bool $isIncludeCategory = false,
        ?int $categoryId = null,
    ): GetBlogPostCollectionQueryQuery {
        return new GetBlogPostCollectionQueryQuery(
            $limit,
            $offset,
            $orderBy,
            $sortOrder,
            $isIncludeCategory,
            $categoryId,
        );
    }

}
