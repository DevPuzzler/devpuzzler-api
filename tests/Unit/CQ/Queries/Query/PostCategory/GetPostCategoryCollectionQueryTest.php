<?php

namespace Tests\Unit\CQ\Queries\Query\PostCategory;

use App\CQ\Queries\Query\PostCategory\GetPostCategoryCollectionQuery;
use Tests\Unit\CQ\Queries\Query\CollectionQueryTest;

class GetPostCategoryCollectionQueryTest extends CollectionQueryTest
{

    public function testSutMethodsReturnDefaultValuesWhenNoParamsProvided(): void
    {
        $this->sut = $this->getSutInstance();

        parent::testSutMethodsReturnDefaultValuesWhenNoParamsProvided();
        $this->assertFalse( $this->sut->getIsIncludePosts() );
    }

    public function testSutHasExpectedMethods(): void
    {
        $this->sut = $this->getSutInstance();

        parent::testSutHasExpectedMethods();
        $this->assertTrue( method_exists( $this->sut, 'getIsIncludePosts' ) );
    }

    public function testGetIsIncludePostsReturnsValueProvidedInConstructor(): void
    {
        $this->sut = $this->getSutInstance(
            self::MOCK_LIMIT,
            self::MOCK_OFFSET,
            self::MOCK_ORDER_BY,
            self::MOCK_SORT_ORDER,
            true
        );

        $this->assertTrue( $this->sut->getIsIncludePosts() );
    }

    protected function getSutInstance(
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $sortOrder = null,
        bool $isIncludePosts = false
    ): GetPostCategoryCollectionQuery {
        return new GetPostCategoryCollectionQuery(
            $limit,
            $offset,
            $orderBy,
            $sortOrder,
            $isIncludePosts
        );
    }

}
