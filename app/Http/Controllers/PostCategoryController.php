<?php

namespace App\Http\Controllers;

use App\CQ\Commands\Command\PostCategory\UpsertPostCategoryCommand;
use App\CQ\Commands\Command\PostCategory\DeletePostCategoryCommand;
use App\CQ\Queries\Query\PostCategory\GetPostCategoryCollectionQuery;
use App\CQ\Queries\Query\PostCategory\GetPostCategoryQuery;
use App\Enums\CollectionParamsEnum;
use App\Http\Requests\PostCategory\UpsertPostCategoryRequest;
use App\Http\Requests\PostCategory\DeletePostCategoryRequest;
use App\Http\Requests\PostCategory\PostCategoryCollectionRequest;
use App\Models\PostCategory;
use App\Http\Responses\JSON\{DefaultErrorResponse, GetResponse, PatchResponse, PostResponse};
use App\Interfaces\CQ\Queries\Query\PostCategory\PostCategoryCollectionInterface;
use App\Interfaces\Responses\JsonResponseInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PostCategoryController extends Controller
{
    public function getPostCategoryCollection( PostCategoryCollectionRequest $request ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch(
                    new GetPostCategoryCollectionQuery(
                        $request->validated( CollectionParamsEnum::LIMIT->value ),
                        $request->validated( CollectionParamsEnum::OFFSET->value ),
                        $request->validated( CollectionParamsEnum::ORDER_BY->value ),
                        $request->validated( CollectionParamsEnum::SORT_ORDER->value ),
                        $request->validated( PostCategoryCollectionInterface::PARAM_INCLUDE_POSTS, false )
                    )
                )->toArray()
            );
        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException( $e );
        }
    }

    public function getPostCategory( int $id ): JsonResponseInterface
    {
        try {
            return GetResponse::create(
                $this->dispatch( new GetPostCategoryQuery( $id ) )->toArray()
            );
        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException( $e );
        }
    }

    public function upsertPostCategory( UpsertPostCategoryRequest $request ): JsonResponseInterface
    {
        try {
            $postCategoryId = $this->dispatch(
                new UpsertPostCategoryCommand( ...array_values( $request->validated() ) )
            );

            return PostResponse::create( [PostCategory::COLUMN_ID => $postCategoryId] );
        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException( $e );
        }
    }

    public function deletePostCategory( DeletePostCategoryRequest $request ): JsonResponseInterface
    {
        try {
            $this->dispatch( new DeletePostCategoryCommand( $request ) );
            return PatchResponse::create();
        } catch ( Exception $e ) {
            return DefaultErrorResponse::createFromException( $e );
        }
    }
}
