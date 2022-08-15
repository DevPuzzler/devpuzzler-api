<?php

namespace Tests\Unit\CQ\Queries\QueryHandler\BlogPost;

use App\CQ\Queries\QueryHandler\BlogPost\GetBlogPostCollectionQueryHandler;
use App\Enums\CollectionParamsEnum;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionQueryInterface;
use App\Models\BlogPost;
use App\Models\BlogPostTag;
use App\Models\PostCategory;
use App\Models\Tag;
use Carbon\Carbon;
use Database\Seeders\BlogPostAndCategoriesSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Mock;
use Tests\TestCase;

class GetBlogPostCollectionQueryHandlerTest extends TestCase
{
    use RefreshDatabase;

    private GetBlogPostCollectionQueryHandler $sut;
    private BlogPostCollectionQueryInterface|Mock $queryMock;

    public function setUp(): void
    {
        $this->sut = new GetBlogPostCollectionQueryHandler();
        $this->queryMock = $this->createMock(BlogPostCollectionQueryInterface::class);

        parent::setUp();
    }

    public function testFirstRecordSkippedWhenOffsetAndLimitProvided(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);

        $this->queryMock
            ->expects($this->once())
            ->method('getLimit')
            ->willReturn(5);
        $this->queryMock
            ->expects($this->once())
            ->method('getOffset')
            ->willReturn(1);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $this->assertEquals(2, $blogPosts->first()->getAttribute(BlogPost::COLUMN_ID));
    }

    public function testNoRecordSkippedWhenOffsetProvidedButNoLimit(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);

        $this->queryMock
            ->expects($this->never())
            ->method('getOffset')
            ->willReturn(1);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        // 101 because after first seed in previous test, indexing starts from 200 for that seeder
        $this->assertEquals(101, $blogPosts->first()->getAttribute(BlogPost::COLUMN_ID));
    }

    public function testInvokeReturnsCollectionWithRecordsWhenNoParamsInQueryProvided(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $this->assertInstanceOf(Collection::class, $this->sut->__invoke($this->queryMock));
        $this->assertCount(100, $blogPosts);
    }

    public function testInvokeReturnsEmptyCollectionWhenNoParamsProvidedAndNoDataInDb(): void
    {
        $blogPosts = $this->sut->__invoke($this->queryMock);

        $this->assertInstanceOf(Collection::class, $this->sut->__invoke($this->queryMock));
        $this->assertCount(0, $blogPosts);
    }

    public function testBlogPostDoesNotIncludeCategoryWhenParamIsDefault(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $this->assertArrayNotHasKey('category', $blogPosts->first()->toArray());
    }

    public function testBlogPostDoesNotIncludeCategoryWhenParamProvidedAndFalse(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $this->assertArrayNotHasKey('category', $blogPosts->first()->toArray());
    }

    public function testBlogPostIncludesCategoryWhenParamProvidedAndTrue(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);
        $this->queryMock
            ->expects($this->once())
            ->method('getIsIncludeCategory')
            ->willReturn(true);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $this->assertArrayHasKey('category', $blogPosts->first()->toArray());
    }

    public function testCollectionHasFixedNumberWhenLimitProvided(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);
        $this->queryMock
            ->expects($this->once())
            ->method('getLimit')
            ->willReturn(5);

        $this->assertCount( 5, $this->sut->__invoke($this->queryMock) );
    }

    public function testBlogPostsBelongToProvidedCategory(): void
    {
        // 71 because it is 7th time we seed DB
        $categoryId = 71;
        $this->seed(BlogPostAndCategoriesSeeder::class);
        $this->queryMock
            ->expects($this->once())
            ->method('getCategoryId')
            ->willReturn($categoryId);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        // We construct 10 blog posts per category,
        // so for 1 category we should have 10 blog posts
        $this->assertCount(10, $blogPosts);
        $this->assertCount(
            10,
            $blogPosts
                ->filter( fn($blogPost) =>
                    $blogPost->getAttribute(BlogPost::COLUMN_CATEGORY_ID) === $categoryId
                )
        );
    }

    public function testCollectionSortedASCWhenOnlyOrderByProvided(): void
    {

        $this->seedOnly2BlogPostsWithSequence(
            [ BlogPost::CREATED_AT => '2022-07-27 10:00:00' ],
            [ BlogPost::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy')
            ->willReturn(BlogPost::CREATED_AT);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $firstBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(0)->getAttribute( BlogPost::CREATED_AT )
        );
        $secondBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(1)->getAttribute( BlogPost::CREATED_AT )
        );

        $this->assertTrue( $secondBlogPostDate->gt($firstBlogPostDate) );
    }

    public function testCollectionSortedDescWhenOrderByAndSortOrderProvided(): void
    {
        $this->seedOnly2BlogPostsWithSequence(
            [ BlogPost::CREATED_AT => '2022-07-27 10:00:00' ],
            [ BlogPost::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy')
            ->willReturn(BlogPost::CREATED_AT);

        $this->queryMock
            ->expects($this->exactly(2))
            ->method('getSortOrder')
            ->willReturn( CollectionParamsEnum::DESC->value );

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $firstBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(0)->getAttribute( BlogPost::CREATED_AT )
        );
        $secondBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(1)->getAttribute( BlogPost::CREATED_AT )
        );

        $this->assertTrue( $firstBlogPostDate->gt($secondBlogPostDate) );
    }

    public function testCollectionSortedAscWhenOrderByAndSortOrderProvided(): void
    {
        $this->seedOnly2BlogPostsWithSequence(
            [ BlogPost::CREATED_AT => '2022-07-27 10:00:00' ],
            [ BlogPost::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy')
            ->willReturn(BlogPost::CREATED_AT);

        $this->queryMock
            ->expects($this->once())
            ->method('getSortOrder')
            ->willReturn( CollectionParamsEnum::ASC->value );

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $firstBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(0)->getAttribute( BlogPost::CREATED_AT )
        );
        $secondBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(1)->getAttribute( BlogPost::CREATED_AT )
        );

        $this->assertTrue( $secondBlogPostDate->gt($firstBlogPostDate) );
    }

    public function testCollectionSortedByDefaultWhenNoOrderByAndSortOrderProvided(): void
    {
        $this->seedOnly2BlogPostsWithSequence(
            [ BlogPost::CREATED_AT => '2022-07-27 10:00:00' ],
            [ BlogPost::CREATED_AT => '2021-07-27 10:00:00' ],
        );

        $this->queryMock
            ->expects($this->once())
            ->method('getOrderBy');
        $this->queryMock
            ->expects($this->never())
            ->method('getSortOrder');

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $firstBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(0)->getAttribute( BlogPost::CREATED_AT )
        );
        $secondBlogPostDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $blogPosts->get(1)->getAttribute( BlogPost::CREATED_AT )
        );

        $this->assertTrue( $firstBlogPostDate->gt($secondBlogPostDate) );
    }

    /**
     * Seed tags via seeder, pick used tag from seeded blog post,
     * check if all retrieved records have that tag
     */
    public function testCollectionReturnsBlogPostsWithRequestedTag(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);

        // Fetch tag from one of seeded blog posts to make sure it is used
        $existingTag = BlogPost::all()
            ?->random()
            ?->getAttribute(BlogPost::RELATION_TAGS)
            ?->first()
            ?->getAttribute('name');

        if (!$existingTag) {
            $this->fail('Could not find Tag. Check [BlogPostAndCategoriesSeeder] seeder.');
        }

        $this->queryMock
            ->expects($this->once())
            ->method('getTags')
            ->willReturn([$existingTag]);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $blogPosts->each( function ( BlogPost $blogPost ) use ($existingTag) {
            $this->assertTrue(
                in_array(
                    $existingTag,
                    array_column($blogPost->tags()->get()->toArray(),
                        Tag::COLUMN_NAME
                    )
                )
            );
        });
    }

    /**
     * Fetch all tags seeded, pick 2 random ones.
     * Fetch all blog posts for these 2 tags
     * Intersect [tags] from blog post with 2 picked ones
     * since it can be only one or both that match
     */
    public function testCollectionReturnsBlogPostWithRequestedMultipleTags(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);

        $existingTags = [];
        foreach( Tag::all() as $tag ) {
            if ( !in_array($tag->getAttribute(Tag::COLUMN_NAME), $existingTags) ) {
                $existingTags[] = $tag->getAttribute(Tag::COLUMN_NAME);
            }

            if ( 2 === count($existingTags) ) {
                break;
            }
        }

        $this->queryMock
            ->expects($this->once())
            ->method('getTags')
            ->willReturn($existingTags);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $blogPosts->each( function ( BlogPost $blogPost ) use ($existingTags) {
            $this->assertNotEmpty(
                array_intersect(
                    array_column($blogPost->tags()->get()->toArray(), Tag::COLUMN_NAME),
                    $existingTags
                )
            );
        });
    }

    public function testCollectionReturnsNoBlogPostsWhenRequestedNonMatchingTag(): void
    {
        $this->seed(BlogPostAndCategoriesSeeder::class);
        $tag = '123fpiwfifow@#!';
        $this->queryMock
            ->expects($this->once())
            ->method('getTags')
            ->willReturn([$tag]);

        $blogPosts = $this->sut->__invoke($this->queryMock);

        $this->assertCount(0, $blogPosts);

    }

    private function seedOnly2BlogPostsWithSequence(array $firstRecordData, array $secondRecordData): void
    {
        PostCategory::factory(1)
            ->has(
                BlogPost::factory(2)
                    ->state( fn($attrs, PostCategory $postCategories ) =>
                        [
                            BlogPost::COLUMN_CATEGORY_ID => $postCategories
                                ->getAttribute(PostCategory::COLUMN_ID)
                        ]
                    )
                    ->state(new Sequence(
                        $firstRecordData,
                        $secondRecordData
                    )),
                PostCategory::RELATION_BLOG_POSTS
            )->create();
    }

}
