<?php

namespace Tests\Unit\CQ\Queries\QueryHandler\PostCategory;

use App\CQ\Queries\Query\PostCategory\GetPostCategoryQuery;
use App\CQ\Queries\QueryHandler\PostCategory\GetPostCategoryQueryHandler;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Mock;
use Tests\TestCase;

class GetPostCategoryQueryHandlerTest extends TestCase
{
    use RefreshDatabase;

    public const MOCK_POST_CATEGORY_ID = 1;

    private GetPostCategoryQueryHandler $sut;
    private GetPostCategoryQuery|Mock $queryMock;

    public function setUp(): void
    {
        $this->sut = new GetPostCategoryQueryHandler();
        $this->queryMock = $this->createMock(GetPostCategoryQuery::class);

        parent::setUp();
    }

    public function testInvokeReturnsSinglePostCategoryData(): void
    {
        PostCategory::factory()->create(
            [PostCategory::COLUMN_ID => self::MOCK_POST_CATEGORY_ID]
        );
        $this->queryMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $postCategory = $this->sut->__invoke($this->queryMock);

        $this->assertInstanceOf(PostCategory::class, $postCategory);
    }

    public function testInvokeThrowsExceptionWhenPostCategoryNonExistent(): void
    {
        $this->queryMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn(self::MOCK_POST_CATEGORY_ID);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage(
            sprintf(
                'No query results for model [App\Models\PostCategory] %s',
                self::MOCK_POST_CATEGORY_ID
            )
        );

        $this->sut->__invoke($this->queryMock);
    }

}
