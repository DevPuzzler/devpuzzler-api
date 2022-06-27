<?php

namespace Tests\Unit\Http\Responses\JSON;

use App\Http\Responses\AbstractJsonResponse;
use App\Http\Responses\JSON\{DefaultErrorResponse, GetResponse};
use App\Interfaces\Responses\JsonResponseInterface;
use App\Interfaces\Responses\{
    ResponseDataValueObjectInterface as ResponseDataInterface,
    ResponseErrorValueObjectInterface as ResponseErrorInterface,
    JsonResponseValueObjectInterface
};
use App\Tools\ValueObjects\Responses\{
    JsonResponseDataVO as JsonResponseData,
    JsonResponseErrorVO as JsonResponseError
};
use Symfony\Component\HttpFoundation\{
    HeaderBag,
    JsonResponse
};
use Tests\TestCase;

/**
 * Since all responses extend/implement the same,
 * this class contains all generic tests which can be re-used.
 * Some of them might get overwritten in dedicated classes.
 *
 * That Test takes by default GET response so no need to create dedicated
 * test for it.
 *
 * That class is also testing AbstractGenericJsonResponse
 */
class JsonResponseTest extends TestCase
{
    protected array $sampleContentData = [
        'test' => 'test'
    ];

    protected const NON_EXISTING_STATUS_CODE = 999;

    protected JsonResponseInterface $sut;

    public function testResponseIsInstanceOfCorrectClassesAndInterfaces(): void
    {
        $this->sut = new GetResponse(
            new JsonResponseData(),
            new JsonResponseError()
        );

        $this->assertInstanceOf(JsonResponse::class, $this->sut);

        $this->assertInstanceOf(AbstractJsonResponse::class, $this->sut);

        $this->assertInstanceOf(JsonResponseInterface::class, $this->sut);
    }

    public function testResponseContainsCorrectInstancesAfterInitializationWithoutValues(): void
    {
        $this->sut = $this->getResponseInstance(
            new JsonResponseData(),
            new JsonResponseError()
        );

        $this->assertInstanceOf(
            JsonResponseValueObjectInterface::class,
            $this->sut->getResponseData()
        );

        $this->assertInstanceOf(
            JsonResponseData::class,
            $this->sut->getResponseData()->getResponseData()
        );

        $this->assertInstanceOf(
            JsonResponseError::class,
            $this->sut->getResponseData()->getResponseError()
        );

        $this->assertIsBool($this->sut->getResponseData()->getIsSuccessResponse());
    }

    public function testResponseContainsNullValuesAfterInitializationWithoutValues(): void
    {
        $this->sut = $this->getResponseInstance(
            new JsonResponseData(),
            new JsonResponseError()
        );

        $this->assertEquals(null, $this->sut->getResponseData()->getResponseData()->getValue());

        $this->assertTrue($this->sut->getResponseData()->getIsSuccessResponse());

        $this->assertNull($this->sut->getResponseData()->getResponseError()->getValue());
    }

    public function testResponseContainsProvidedContent(): void
    {
        $this->sut = $this->getResponseInstance(
            new JsonResponseData($this->sampleContentData),
            new JsonResponseError()
        );

        $this->assertEquals(
            $this->sampleContentData,
            $this->sut->getResponseData()->getResponseData()->getValue()
        );
    }

    public function testIsSuccessResponseReturnsTrueWhenStatusInRangeOfSuccessfulStatusCodes(): void
    {
        $this->sut = $this->getResponseInstance(
            new JsonResponseData(),
            new JsonResponseError()
        );

        $this->assertTrue($this->sut->getResponseData()->getIsSuccessResponse());
    }

    public function testHeadersContentTypeIsApplicationJsonByDefault(): void
    {
        $this->sut = $this->getResponseInstance(
            new JsonResponseData(),
            new JsonResponseError()
        );

        /** @var HeaderBag $headers */
        $headers = $this->sut->headers;

        $this->assertEquals('application/json', $headers->get('content-type'));
    }

    public function testHeadersContentTypeIsOverwrittenIfProvidedInConstructor(): void
    {
        $this->sut = $this->getResponseInstance(
            new JsonResponseData(),
            new JsonResponseError(),
            ['content-type' => 'text/html']
        );

        /** @var HeaderBag $headers */
        $headers = $this->sut->headers;

        $this->assertEquals('text/html', $headers->get('content-type'));
    }

    public function testStaticInstanceWillReturnNoDataWhenNoDataProvided(): void
    {
        $this->sut = $this->createInstanceViaStaticMethod();

        $this->assertInstanceOf(JsonResponseInterface::class, $this->sut);

        $this->assertNull($this->sut->getResponseData()->getResponseData()->getValue());
        $this->assertNull($this->sut->getResponseData()->getResponseError()->getValue());
    }

    public function testStaticInstanceWillReturnDataWhenProvided(): void
    {
        $this->sut = $this->createInstanceViaStaticMethod($this->sampleContentData, 'error');

        $this->assertInstanceOf(JsonResponseInterface::class, $this->sut);

        $this->assertEquals($this->sampleContentData, $this->sut->getResponseData()->getResponseData()->getValue());
        $this->assertEquals('error', $this->sut->getResponseData()->getResponseError()->getValue());

    }

    /**
     * User Get response by default
     */
    protected function getResponseInstance(
        ResponseDataInterface $responseData,
        ResponseErrorInterface $responseError,
        array $headers = []
    ): ?JsonResponseInterface
    {
        return new GetResponse($responseData, $responseError, $headers);
    }

    protected function createInstanceViaStaticMethod(
        ?array $data = null,
        mixed $error = null,
        array $headers = [],
    ): JsonResponseInterface {
        return GetResponse::create($data, $error, $headers);
    }

    protected function getErrorResponseInstance(
        ?ResponseDataInterface $responseData = null,
        ?ResponseErrorInterface $responseError = null,
        array $headers = [],
        ?int $customStatusCode = null,
    ): ?JsonResponseInterface
    {
        return new DefaultErrorResponse($responseData, $responseError, $headers, $customStatusCode );
    }

}
