<?php

namespace Tests\Feature;

use App\Tools\ValueObjects\Responses\JsonResponseVO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

abstract class AbstractFeatureTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        $this->withHeader('Accept', 'application/json');

        parent::setUp();
    }

    protected function assertResponseJsonContainsSuccessErrorDataParams(
        AssertableJson $json
    ): AssertableJson {
        return $json->hasAll([
            JsonResponseVO::PARAM_SUCCESS,
            JsonResponseVO::PARAM_DATA,
            JsonResponseVO::PARAM_ERROR,
        ]);
    }
}
