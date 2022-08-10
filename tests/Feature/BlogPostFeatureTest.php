<?php

namespace Tests\Feature;

use App\Enums\CollectionParamsEnum;
use App\Interfaces\CQ\Queries\Query\BlogPost\BlogPostCollectionQueryInterface;
use App\Models\BlogPost;
use App\Models\PostCategory;
use App\Models\User;
use App\Tools\ValueObjects\Responses\JsonResponseVO;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Testing\Fluent\AssertableJson;

class BlogPostFeatureTest extends AbstractFeatureTest
{

    public const MOCK_BLOG_POST_ID = 1;
    public const MOCK_LIMIT = 1;
    public const MOCK_OFFSET = 1;
    public const MOCK_BLOG_POST = [
        BlogPost::COLUMN_CATEGORY_ID => 1,
        BlogPost::COLUMN_TITLE => 'title',
        BlogPost::COLUMN_EXCERPT => 'excerpt',
        BlogPost::COLUMN_CONTENT => '<h1>CONTENT</h1>',
        BlogPost::COLUMN_IS_ACTIVE => 1,
        BlogPost::COLUMN_IS_RESTRICTED => 0,
    ];

    public function testGetSingleBlogPostByIdReturnsSingleBlogPost(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory()->create(
            [BlogPost::COLUMN_ID => self::MOCK_BLOG_POST_ID]
        );

        $this
            ->get(
                sprintf(
                    '/api/posts/%s',
                    self::MOCK_BLOG_POST_ID
                )
            )
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                    ->has(JsonResponseVO::PARAM_DATA, fn (AssertableJson $json) =>
                        $this
                            ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                            ->where(BlogPost::COLUMN_ID, self::MOCK_BLOG_POST_ID)
                    )
            );
    }

    public function testGetSingleBlogPostByIdReturnsErrorWhenNonExisting(): void
    {
        $nonExistingBlogPostId = 999;
        $this
            ->get(sprintf('/api/posts/%s', $nonExistingBlogPostId))
            ->assertNotFound()
            ->assertJson( fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->where(
                    JsonResponseVO::PARAM_ERROR,
                    sprintf(
                        'No query results for model [App\\Models\\BlogPost] %s',
                        $nonExistingBlogPostId
                    )
                )
            );
    }

    public function testGetBlogPostCollectionReturnsCollectionOfNotDeletedBlogPosts(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory(3)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
                [
                    BlogPost::COLUMN_ID => 3,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => now(),
                ],
            )
        )->create();

        $this
            ->get('api/posts')
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                    ->has(JsonResponseVO::PARAM_DATA, 2, fn (AssertableJson $json) =>
                        $this->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                    )
            );
    }

    public function testGetBlogPostCollectionReturnsNoRecordsWhenOnlyDeletedBlogPostsExist(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory()->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => now()
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => now()
                ],
            )
        )->create();

        $this
            ->get('/api/posts')
            ->assertJson( fn (AssertableJson $json) =>
            $this
                ->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, 0)
            );
    }

    public function testGetBlogPostCollectionReturnsEqualOrLessReturnsThatGivenLimit(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory()->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
                [
                    BlogPost::COLUMN_ID => 3,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
            )
        )->create();

        $this
            ->get(sprintf('/api/posts?limit=%s', self::MOCK_LIMIT))
            ->assertJson( fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                    ->has(JsonResponseVO::PARAM_DATA, self::MOCK_LIMIT, fn (AssertableJson $json) =>
                    $this->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                    )
            );
    }

    public function testBlogPostCollectionReturnsLimitedAndOffsetRecordsWhenParamsGiven(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory(3)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
                [
                    BlogPost::COLUMN_ID => 3,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                ],
            )
        )->create();

        $this
            ->get(
                sprintf(
                    '/api/posts?limit=%s&offset=%s',
                    self::MOCK_LIMIT,
                    self::MOCK_OFFSET
                )
            )
            ->assertJson( fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                    ->has(JsonResponseVO::PARAM_DATA, self::MOCK_LIMIT, fn (AssertableJson $json) =>
                        $this
                            ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                            ->where(BlogPost::COLUMN_ID, 2) // need 2nd record
                        )
            );
    }

    /**
     * Test that provided updated_at param (order_by) works fine and sort_order
     * Is by default 'asc' (not providing it in that test)
     */
    public function testCollectionReturnsRecordsOrderedByUpdatedAtAndSortByDefaultAsc(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory(2)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-08 10:00:00',
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                ],
            )
        )->create();

        $this
            ->get(sprintf('/api/posts?order_by=%s', BlogPost::UPDATED_AT))
            ->assertJson( fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                    ->has(JsonResponseVO::PARAM_DATA, 2, fn (AssertableJson $json) =>
                        $this
                            ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                            ->where(BlogPost::UPDATED_AT, '2022-08-08T10:00:00.000000Z')
                    )
            );
    }

    /**
     * Test that provided updated_at param (order_by) works fine together with sort_order=asc
     */
    public function testCollectionReturnsRecordsOrderedByUpdatedAtAndSortOrderAsc(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory(2)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-08 10:00:00',
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                ],
            )
        )->create();

        $this
            ->get(
                sprintf(
                    '/api/posts?%s=%s&%s=%s',
                    CollectionParamsEnum::ORDER_BY->value,
                    BlogPost::UPDATED_AT,
                    CollectionParamsEnum::SORT_ORDER->value,
                    CollectionParamsEnum::ASC->value
                )
            )
            ->assertJson( fn (AssertableJson $json) =>
            $this
                ->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, 2, fn (AssertableJson $json) =>
                $this
                    ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                    ->where(BlogPost::UPDATED_AT, '2022-08-08T10:00:00.000000Z')
                )
            );
    }

    /**
     * Test that provided updated_at param (order_by) works fine
     * Together with sort_order = desc (provided)
     */
    public function testCollectionReturnsRecordsOrderedByUpdatedAtAndSortOrderDesc(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory(2)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-08 10:00:00',
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                ],
            )
        )->create();

        $this
            ->get(
                sprintf(
                    '/api/posts?%s=%s&%s=%s',
                    CollectionParamsEnum::ORDER_BY->value,
                    BlogPost::UPDATED_AT,
                    CollectionParamsEnum::SORT_ORDER->value,
                    CollectionParamsEnum::DESC->value
                )
            )
            ->assertJson( fn (AssertableJson $json) =>
            $this
                ->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, 2, fn (AssertableJson $json) =>
                $this
                    ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                    ->where(BlogPost::UPDATED_AT, '2022-08-09T10:00:00.000000Z')
                )
            );
    }

    public function testCollectionReturnsCategoryAssignedToBlogPostWhenIsIncludeCategoryParamTrue(): void
    {
        PostCategory::factory()->create();
        BlogPost::factory(2)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-08 10:00:00',
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                ],
            )
        )->create();

        $this
            ->get(
                sprintf(
                    '/api/posts/?%s=1',
                    BlogPostCollectionQueryInterface::PARAM_INCLUDE_CATEGORY
                )
            )
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
                $this->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, 2, fn (AssertableJson $json) =>
                    $this
                        ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                        ->has('category', fn(AssertableJson $json) =>
                            $json->hasAll([
                                PostCategory::COLUMN_ID,
                                PostCategory::COLUMN_NAME,
                                PostCategory::COLUMN_DESCRIPTION,
                                PostCategory::CREATED_AT
                            ])
                        )
                )
            );
    }

    public function testCollectionReturnsNoRecordsWhenCategoryIdDoesNotExist(): void
    {
        PostCategory::factory()->create([PostCategory::COLUMN_ID => 1]);
        BlogPost::factory(2)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-08 10:00:00',
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                ],
            )
        )->create();

        $this
            ->get(
                sprintf(
                    '/api/posts/?%s=999',
                    BlogPost::COLUMN_CATEGORY_ID
                )
            )
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
            $this->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, 0)
            );
    }

    public function testCollectionReturnsOnlyRecordsBelongingToRequestedCategory(): void
    {
        PostCategory::factory(2)
            ->state(new Sequence(
                [PostCategory::COLUMN_ID => 1],
                [PostCategory::COLUMN_ID => 2],
            ))
            ->create();
        BlogPost::factory(3)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-08 10:00:00',
                    BlogPost::COLUMN_CATEGORY_ID => 1,
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                    BlogPost::COLUMN_CATEGORY_ID => 1,
                ],
                [
                    BlogPost::COLUMN_ID => 3,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                    BlogPost::COLUMN_CATEGORY_ID => 2,
                ],
            )
        )->create();

        $requestedCategoryId = 1;
        $this
            ->get(
                sprintf(
                    '/api/posts/?%s=%s',
                    BlogPost::COLUMN_CATEGORY_ID,
                    $requestedCategoryId
                )
            )
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
            $this->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, 2, fn(AssertableJson $json) =>
                $this
                    ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                    ->where(BlogPost::COLUMN_CATEGORY_ID, $requestedCategoryId)
                )
            );
    }

    public function testCollectionReturnsOnlyRecordsBelongingToRequestedCategoryWithCategoryData(): void
    {
        PostCategory::factory(2)
            ->state(new Sequence(
                [PostCategory::COLUMN_ID => 1],
                [PostCategory::COLUMN_ID => 2],
            ))
            ->create();
        BlogPost::factory(3)->state(
            new Sequence(
                [
                    BlogPost::COLUMN_ID => 1,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-08 10:00:00',
                    BlogPost::COLUMN_CATEGORY_ID => 1,
                ],
                [
                    BlogPost::COLUMN_ID => 2,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                    BlogPost::COLUMN_CATEGORY_ID => 1,
                ],
                [
                    BlogPost::COLUMN_ID => 3,
                    BlogPost::COLUMN_IS_ACTIVE => 1,
                    BlogPost::COLUMN_DELETED_AT => null,
                    BlogPost::UPDATED_AT => '2022-08-09 10:00:00',
                    BlogPost::COLUMN_CATEGORY_ID => 2,
                ],
            )
        )->create();

        $requestedCategoryId = 1;
        $this
            ->get(
                sprintf(
                    '/api/posts/?%s=%s&%s=1',
                    BlogPost::COLUMN_CATEGORY_ID,
                    $requestedCategoryId,
                    BlogPostCollectionQueryInterface::PARAM_INCLUDE_CATEGORY
                )
            )
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
            $this->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, 2, fn(AssertableJson $json) =>
                $this
                    ->assertBlogPostRecordHasAllExpectedParamsExposed($json)
                    ->where(BlogPost::COLUMN_CATEGORY_ID, $requestedCategoryId)
                    ->has('category', fn(AssertableJson $json) =>
                        $json->hasAll([
                            PostCategory::COLUMN_ID,
                            PostCategory::COLUMN_NAME,
                            PostCategory::COLUMN_DESCRIPTION,
                            PostCategory::CREATED_AT
                        ])
                        ->where(PostCategory::COLUMN_ID, $requestedCategoryId)
                    )
                )
            );
    }

    public function testUpsertBlogPostInsertsNewRecordWhenNonExistingAndReturnsId(): void
    {
        PostCategory::factory()->create([
            PostCategory::COLUMN_ID => 1
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $this
            ->post('/api/posts', self::MOCK_BLOG_POST)
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
            $this
                ->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, fn ( AssertableJson $json ) =>
                    $json->has(BlogPost::COLUMN_ID)
                )
        );
    }

    public function testUpsertBlogPostRequiresAuthentication(): void
    {
        $this
            ->post('/api/posts', self::MOCK_BLOG_POST)
            ->assertUnauthorized()
            ->assertJson( fn (AssertableJson $json) =>
                $this->assertResponseUnauthenticated($json)
            );
    }

    /**
     * Send empty JSON to see all required fields and check them
     */
    public function testUpsertBlogPostRequiresBlogPostData(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this
            ->post('/api/posts', [])
            ->assertUnprocessable()
            ->assertJson( fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                    ->has(JsonResponseVO::PARAM_ERROR, fn (AssertableJson $json) =>
                        $json->hasAll(...array_keys(self::MOCK_BLOG_POST))
                    )
            );
    }

    public function testUpsertUpdatesExistingBlogPost(): void
    {
        PostCategory::factory()->create([
            PostCategory::COLUMN_ID => 1
        ]);
        $blogPost = BlogPost::factory()->create(self::MOCK_BLOG_POST);
        $user = User::factory()->create();
        $this->actingAs($user);
        $blogPost->setAttribute(BlogPost::COLUMN_CONTENT, '<h2>UPDATED</h2>');

        $this
            ->post(
                '/api/posts',
                $blogPost->toArray()
            )
            ->assertCreated()->assertJson(fn (AssertableJson $json) =>
                $this
                    ->assertResponseJsonContainsSuccessErrorDataParams($json)
                ->has(JsonResponseVO::PARAM_DATA, fn (AssertableJson $json) =>
                    $json->has(BlogPost::COLUMN_ID)
                    ->where(BlogPost::COLUMN_ID, $blogPost->getAttribute(BlogPost::COLUMN_ID))
                )
            );
        $this->assertDatabaseHas(BlogPost::TABLE_NAME, [
            'title' => $blogPost->getAttribute(BlogPost::COLUMN_TITLE),
            'content' => $blogPost->getAttribute(BlogPost::COLUMN_CONTENT),
        ]);
    }

    protected function assertBlogPostRecordHasAllExpectedParamsExposed(
        AssertableJson $json
    ): AssertableJson {
        return $json
            ->hasAll([
                BlogPost::COLUMN_ID,
                BlogPost::COLUMN_CATEGORY_ID,
                BlogPost::COLUMN_TITLE,
                BlogPost::COLUMN_EXCERPT,
                BlogPost::COLUMN_CONTENT,
                BlogPost::COLUMN_IS_ACTIVE,
                BlogPost::COLUMN_IS_RESTRICTED,
                BlogPost::CREATED_AT,
                BlogPost:: UPDATED_AT,
            ]);
    }

}
