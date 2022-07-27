<?php

namespace Tests\Unit\CQ\Queries\QueryHandler\BlogPost;

use App\CQ\Queries\Query\BlogPost\GetBlogPostQuery;
use App\CQ\Queries\QueryHandler\BlogPost\GetBlogPostQueryHandler;
use App\Models\BlogPost;
use App\Models\PostCategory;
use Database\Seeders\BlogPostAndCategoriesSeeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Mock;
use Tests\TestCase;

class GetBlogPostQueryHandlerTest extends TestCase
{
    use RefreshDatabase;

    public const MOCK_BLOG_POST_ID = 1;

    private GetBlogPostQueryHandler $sut;
    private GetBlogPostQuery|Mock $queryMock;

    public function setUp(): void
    {
        $this->sut = new GetBlogPostQueryHandler();
        $this->queryMock = $this->createMock(GetBlogPostQuery::class);

        parent::setUp();
    }

    public function testInvokeReturnsSingleBlogPostData(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory()->create(
            [BlogPost::COLUMN_ID => self::MOCK_BLOG_POST_ID]
        );
        $this->queryMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn(self::MOCK_BLOG_POST_ID);

        $blogPost = $this->sut->__invoke($this->queryMock);

        $this->assertInstanceOf(BlogPost::class, $blogPost);
        $this->assertEquals(
            self::MOCK_BLOG_POST_ID,
            $blogPost->getAttribute(BlogPost::COLUMN_ID)
        );
    }

    public function testInvokeThrowsExceptionWhenBlogPostNonExistent(): void
    {
        $this->queryMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn(self::MOCK_BLOG_POST_ID);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage(
            sprintf(
                'No query results for model [App\Models\BlogPost] %s',
                self::MOCK_BLOG_POST_ID
            )
        );

        $this->sut->__invoke($this->queryMock);
    }

}
