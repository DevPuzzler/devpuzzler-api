<?php

namespace Tests\Unit\CQ\Queries\Query\BlogPost;

use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use Tests\TestCase;

class GetBlogPostQueryTest extends TestCase
{
    public const MOCK_ID = 1;

    private GetBlogPostQuery $sut;

    public function testGetIdReturnsIdGivenInConstructor(): void
    {
        $this->sut = new GetBlogPostQuery(self::MOCK_ID);

        $this->assertEquals(self::MOCK_ID, $this->sut->getId());
    }
}
