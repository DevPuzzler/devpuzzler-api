<?php

namespace Tests\Unit\CQ\Queries\Query\PostCategory;

use App\CQ\Queries\Query\PostCategory\GetPostCategoryQuery;
use Tests\TestCase;

class GetPostCategoryQueryTest extends TestCase
{
    public const MOCK_ID = 1;

    private GetPostCategoryQuery $sut;

    public function testGetIdReturnsIdGivenInConstructor(): void
    {
        $this->sut = new GetPostCategoryQuery(self::MOCK_ID);

        $this->assertEquals(self::MOCK_ID, $this->sut->getId());
    }
}
