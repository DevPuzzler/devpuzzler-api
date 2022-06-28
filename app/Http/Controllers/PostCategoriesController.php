<?php

namespace App\Http\Controllers;

use App\CQ\Commands\Command\PostCategories\CreatePostCategoryCommand;
use App\CQ\Commands\Command\PostCategories\DeletePostCategoryCommand;
use App\CQ\Queries\Query\PostCategories\GetPostCategoriesCollectionQuery;
use App\CQ\Queries\Query\PostCategories\GetPostCategoryQuery;
use App\Enums\CollectionRulesEnum;
use App\Http\Requests\CreatePostCategoryRequest;
use App\Http\Requests\DeletePostCategoryRequest;
use App\Http\Requests\PostCategory\PostCategoryCollectionRequest;
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionInterface;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Http\Responses\JSON\{GetResponse, DefaultErrorResponse, PatchResponse, PostResponse};
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PostCategoriesController extends Controller
{
    public function getPostCategoryCollection( PostCategoryCollectionRequest $request ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch(
                    new GetPostCategoriesCollectionQuery(
                        $request->validated(CollectionRulesEnum::LIMIT->value),
                        $request->validated(CollectionRulesEnum::ORDER_BY->value),
                        $request->validated(CollectionRulesEnum::SORT_ORDER->value),
                        $request->validated(PostCategoryCollectionInterface::PARAM_INCLUDE_POSTS, false)
                    )
                )->toArray()
            );
        } catch ( Exception $e) {
            return DefaultErrorResponse::create(
                null,
                'No records found',
                [],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function getPostCategory( int $id ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch( new GetPostCategoryQuery( $id ) )->toArray()
            );
        } catch ( Exception $e ) {
            return DefaultErrorResponse::create(
                null,
                'No record found',
                [],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function createPostCategory( CreatePostCategoryRequest $request ): JsonResponseInterface
    {
        try {
            $this->dispatch( new CreatePostCategoryCommand($request) );
            return PostResponse::create();
        } catch ( Exception $e ) {
            return DefaultErrorResponse::create( null, $e->getMessage() );
        }
    }

    public function deletePostCategory( DeletePostCategoryRequest $request ): JsonResponseInterface
    {
        try {
            $this->dispatch( new DeletePostCategoryCommand( $request ) );
            return PatchResponse::create();
        } catch ( Exception $e ) {
            return DefaultErrorResponse::create( null, $e->getMessage() );
        }
    }
}
