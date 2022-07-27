<?php

namespace Tests\Unit\CQ\Queries\QueryHandler\PostCategory;

use App\CQ\Queries\QueryHandler\BlogPost\GetBlogPostCollectionQueryHandler;
use App\CQ\Queries\QueryHandler\PostCategory\GetPostCategoryCollectionQueryHandler;
use App\Enums\CollectionParamsEnum;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionQueryInterface;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionQueryInterface;
use App\Models\BlogPost;
use App\Models\PostCategory;
use Carbon\Carbon;
use Database\Seeders\BlogPostAndCategoriesSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Mock;
use Tests\TestCase;

class GetPostCategoryCollectionQueryHandlerTest extends TestCase
{
    use RefreshDatabase;

    private GetPostCategoryCollectionQueryHandler $sut;
    private PostCategoryCollectionQueryInterface|Mock $queryMock;

    public function setUp(): void
    {
        $this->sut = new GetPostCategoryCollectionQueryHandler();
        $this->queryMock = $this->createMock(PostCategoryCollectionQueryInterface::class);

        parent::setUp();
    }

    public function testInvokeReturnsCollectionWhenNoPramsProvided(): void
    {
        $this->seedOnly2PostCategoriesWithSequence();

        $postCategories = $this->sut->__invoke($this->queryMock);

        $this->assertInstanceOf(Collection::class, $postCategories);
        $this->assertCount(2, $postCategories);
    }

    public function testPostCategoriesDoNotContainBlogPostsWhenIncludeBlogPostsParamNotProvided(): void
    {
        $this->seedCategoryWithBlogPosts();
        $postCategories = $this->sut->__invoke($this->queryMock);

        $this->assertArrayNotHasKey('blog_posts', $postCategories->first()->toArray());
    }

    public function testPostCategoriesDoNotContainBlogPostsWhenIncludeBlogPostsParamFalse(): void
    {
        $this->seedCategoryWithBlogPosts();
        $this->queryMock
            ->expects($this->once())
            ->method('getIsIncludePosts')
            ->willReturn(false);

        $postCategories = $this->sut->__invoke($this->queryMock);

        $this->assertArrayNotHasKey('blog_posts', $postCategories->first()->toArray());
    }

    public function testPostCategoriesContainBlogPostsWhenIncludeBlogPostsParamTrue(): void
    {
        $this->seedCategoryWithBlogPosts();
        $this->queryMock
            ->expects($this->once())
            ->method('getIsIncludePosts')
            ->willReturn(true);

        $this->assertArrayHasKey(
            'blog_posts',
            $this
                ->sut
                ->__invoke($this->queryMock)
                ->first()
                ->toArray()
        );
    }

    public function testCollectionHasFixedNumberWhenLimitProvided(): void
    {
        $this->seedOnly2PostCategoriesWithSequence();
        $this->queryMock
            ->expects($this->once())
            ->method('getLimit')
            ->willReturn(1);

        $this->assertEquals(1, $this->sut->__invoke($this->queryMock)->count());
    }

    private function seedOnly2PostCategoriesWithSequence(array $firstRecordData = [], array $secondRecordData = []): void
    {
        PostCategory::factory(2)
            ->state( new Sequence(
                $firstRecordData,
                    $secondRecordData,
                )
            )->create();
    }

    public function testCollectionSortedASCWhenOnlyOrderByProvided(): void
    {

        $this->seedOnly2PostCategoriesWithSequence(
            [ PostCategory::CREATED_AT => '2022-07-27 10:00:00' ],
            [ PostCategory::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy')
            ->willReturn(PostCategory::CREATED_AT);

        $postCategories = $this->sut->__invoke($this->queryMock);

        $firstPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(0)->getAttribute( PostCategory::CREATED_AT )
        );
        $secondPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(1)->getAttribute( PostCategory::CREATED_AT )
        );

        $this->assertTrue( $secondPostCategoryDate->gt($firstPostCategoryDate) );
    }

    public function testCollectionSortedDescWhenOrderByAndSortOrderProvided(): void
    {
        $this->seedOnly2PostCategoriesWithSequence(
            [ PostCategory::CREATED_AT => '2022-07-27 10:00:00' ],
            [ PostCategory::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy')
            ->willReturn(PostCategory::CREATED_AT);

        $this->queryMock
            ->expects($this->exactly(2))
            ->method('getSortOrder')
            ->willReturn( CollectionParamsEnum::DESC->value );

        $postCategories = $this->sut->__invoke($this->queryMock);

        $firstPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(0)->getAttribute( PostCategory::CREATED_AT )
        );
        $secondPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(1)->getAttribute( PostCategory::CREATED_AT )
        );

        $this->assertTrue( $firstPostCategoryDate->gt($secondPostCategoryDate) );
    }

    public function testCollectionSortedAscWhenOrderByAndSortOrderProvided(): void
    {
        $this->seedOnly2PostCategoriesWithSequence(
            [ PostCategory::CREATED_AT => '2022-07-27 10:00:00' ],
            [ PostCategory::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy')
            ->willReturn(PostCategory::CREATED_AT);

        $this->queryMock
            ->expects($this->once())
            ->method('getSortOrder')
            ->willReturn( CollectionParamsEnum::ASC->value );

        $postCategories = $this->sut->__invoke($this->queryMock);

        $firstPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(0)->getAttribute( PostCategory::CREATED_AT )
        );
        $secondPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(1)->getAttribute( PostCategory::CREATED_AT )
        );

        $this->assertTrue( $secondPostCategoryDate->gt($firstPostCategoryDate) );
    }

    public function testCollectionSortedByDefaultWhenNoOrderByAndSortOrderProvided(): void
    {
        $this->seedOnly2PostCategoriesWithSequence(
            [ BlogPost::CREATED_AT => '2022-07-27 10:00:00' ],
            [ BlogPost::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy');
        $this->queryMock
            ->expects($this->never())
            ->method('getSortOrder');

        $postCategories = $this->sut->__invoke($this->queryMock);

        $firstPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(0)->getAttribute( PostCategory::CREATED_AT )
        );
        $secondPostCategoryDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $postCategories->get(1)->getAttribute( PostCategory::CREATED_AT )
        );

        $this->assertTrue( $firstPostCategoryDate->gt($secondPostCategoryDate) );
    }

    private function seedCategoryWithBlogPosts(): void
    {
        PostCategory::factory(1)
            ->has(
                BlogPost::factory(2),
                'blogPosts'
            )->create();
    }
}
