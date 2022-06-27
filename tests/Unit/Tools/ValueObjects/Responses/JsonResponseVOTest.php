<?php

namespace Tests\Unit\Tools\ValueObjects\Responses;

use App\Interfaces\Responses\ResponseDataValueObjectInterface as ResponseDataInterface;
use App\Interfaces\Responses\ResponseErrorValueObjectInterface as ResponseErrorInterface;
use App\Tools\ValueObjects\Responses\JsonResponseVO as JsonResponseData;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class JsonResponseVOTest extends TestCase
{
    public const SAMPLE_CONTENT_DATA = [
        'testKey' => 'testValue',
    ];

    public const SAMPLE_RESPONSE_ERROR = 'Sample response error.';

    protected MockObject|ResponseDataInterface $responseDataMock;
    protected MockObject|ResponseErrorInterface $responseErrorMock;

    protected JsonResponseData $sut;

    public function setUp(): void
    {
        $this->responseDataMock = $this->createMock(ResponseDataInterface::class);
        $this->responseErrorMock = $this->createMock(ResponseErrorInterface::class);

        $this->sut = $this->getInstance();

        parent::setUp();
    }

    public function testGetResponseDataReturnsResponseDataObject(): void
    {
        $this->assertInstanceOf(ResponseDataInterface::class, $this->sut->getResponseData());
    }

    public function testGetResponseErrorReturnsResponseErrorObject(): void
    {
        $this->assertInstanceOf(ResponseErrorInterface::class, $this->sut->getResponseError());
    }

    public function testGetIsSuccessResponseReturnsGivenValue(): void
    {
        // $this->sut is by default giving 'true'
        $this->assertTrue($this->sut->getIsSuccessResponse());

        $this->sut = $this->getInstance(false);

        $this->assertFalse($this->sut->getIsSuccessResponse());
    }

    public function testGetResponseDataArrayContainsNeededKeysAndCallsFunctionsOnce(): void
    {
        $this->responseDataMock
            ->expects($this->once())
            ->method('getValue');

        $this->responseErrorMock
            ->expects($this->once())
            ->method('getValue');

        $this->sut = new JsonResponseData(
            $this->responseDataMock,
            $this->responseErrorMock,
            true
        );

        $dataArray = $this->sut->getResponseDataArray();

        $this->assertArrayHasKey(JsonResponseData::PARAM_SUCCESS, $dataArray);

        $this->assertArrayHasKey(JsonResponseData::PARAM_DATA, $dataArray);

        $this->assertArrayHasKey(JsonResponseData::PARAM_ERROR, $dataArray);
    }

    public function testGetResponseDataArrayReturnsGivenResponseData(): void
    {
        $this->responseDataMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn(self::SAMPLE_CONTENT_DATA);

        $this->assertEquals(
            self::SAMPLE_CONTENT_DATA,
            $this->sut->getResponseDataArray()[JsonResponseData::PARAM_DATA]);
    }

    public function testGetResponseDataArrayReturnsGivenErrorResponseData(): void
    {
        $this->responseErrorMock
            ->expects($this->once())
            ->method('getValue')
            ->willReturn(self::SAMPLE_RESPONSE_ERROR);

        $this->assertEquals(
            self::SAMPLE_RESPONSE_ERROR,
            $this->sut->getResponseDataArray()[JsonResponseData::PARAM_ERROR]
        );
    }

    public function testGetResponseDataArrayReturnsGivenSuccessResponseBool(): void
    {
        // By default, $this->sut gets it as true
        $this->assertTrue($this->sut->getResponseDataArray()[JsonResponseData::PARAM_SUCCESS]);

        $this->sut = $this->getInstance(false);

        $this->assertFalse($this->sut->getResponseDataArray()[JsonResponseData::PARAM_SUCCESS]);
    }

    protected function getInstance(bool $isSuccessResponse = true): JsonResponseData
    {
        return new JsonResponseData(
            $this->responseDataMock,
            $this->responseErrorMock,
            $isSuccessResponse
        );
    }
}
