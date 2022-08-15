<?php

namespace Tests\Unit\CQ\Queries\Query\BlogPost;

use App\CQ\Queries\Query\BlogPost\GetBlogPostCollectionQuery;
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
        $this->assertTrue( method_exists( $this->sut, 'getTags' ) );
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

    public function testGetTagsReturnsArrayWithSingleItemWhenStringWithComaAtEndProvided(): void
    {
        $this->sut = $this->getSutInstance(
            self::MOCK_LIMIT,
            self::MOCK_OFFSET,
            self::MOCK_ORDER_BY,
            self::MOCK_SORT_ORDER,
            true,
            self::MOCK_CATEGORY_ID,
            'test,'
        );

        $this->assertEquals(['test'], $this->sut->getTags());
    }

    public function testGetTagsReturnsArrayOf2ElemsWhenStringWith2ElemsProvided(): void
    {
        $this->sut = $this->getSutInstance(
            self::MOCK_LIMIT,
            self::MOCK_OFFSET,
            self::MOCK_ORDER_BY,
            self::MOCK_SORT_ORDER,
            true,
            self::MOCK_CATEGORY_ID,
            'test1,test2'
        );
        $this->assertEquals(['test1', 'test2'], $this->sut->getTags());
    }

    public function testGetTagsReturnsNullWhenNoValueInConstructor(): void
    {
        $this->sut = $this->getSutInstance();

        $this->assertNull($this->sut->getTags());
    }

    protected function getSutInstance(
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
        bool $isIncludeCategory = false,
        ?int $categoryId = null,
        ?string $tags = null,
    ): GetBlogPostCollectionQuery {
        return new GetBlogPostCollectionQuery(
            $limit,
            $offset,
            $orderBy,
            $sortOrder,
            $isIncludeCategory,
            $categoryId,
            $tags,
        );
    }

}
