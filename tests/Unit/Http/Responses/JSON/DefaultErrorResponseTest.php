<?php

namespace Tests\Unit\Http\Responses\JSON;

use App\Http\Responses\AbstractJsonResponse;
use App\Http\Responses\JSON\DefaultErrorResponse;
use App\Interfaces\Responses\JsonResponseInterface;
use App\Tools\ValueObjects\Responses\{
    JsonResponseDataVO as JsonResponseContent,
    JsonResponseErrorVO as JsonResponseError
};
use Exception;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use InvalidArgumentException;
use Mockery\Mock;
use Symfony\Component\HttpFoundation\Response;

class DefaultErrorResponseTest extends JsonResponseTest
{
    public const EXCEPTION_CONTENT_TEXT = 'Exception text';

    protected const MESSAGE_BAG_ERROR = [
        'Missing password field.'
    ];

    protected MessageBag|Mock $messageBagMock;
    protected Validator|Mock $validatorMock;

    public function setUp(): void
    {
        $this->messageBagMock = $this->createMock(MessageBag::class);
        $this->validatorMock = $this->createMock(Validator::class);

        parent::setUp();
    }

    public function testErrorResponseContainsProvidedErrorMessage(): void
    {
        $this->sut = $this->getErrorResponseInstance(
            new JsonResponseContent(),
            new JsonResponseError('Response error message.'),
            [],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );

        $this->assertEquals(
            'Response error message.',
            $this->sut->getResponseData()->getResponseError()->getValue()
        );

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $this->sut->getStatusCode());
    }

    public function testExceptionWhenProvidingNonExistingStatusCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                AbstractJsonResponse::STATUS_CODE_EXCEPTION_PATTERN,
                self::NON_EXISTING_STATUS_CODE
            )
        );

        $this->sut = $this->getErrorResponseInstance(
            new JsonResponseContent(),
            new JsonResponseError(self::NON_EXISTING_STATUS_CODE),
            [],
            self::NON_EXISTING_STATUS_CODE
        );
    }

    public function testIsSuccessResponseReturnsTrueWhenStatusInRangeOfSuccessfulStatusCodesForErrorResponse(): void
    {
        $this->sut = $this->getErrorResponseInstance(
            new JsonResponseContent(),
            new JsonResponseError(),
            [],
            Response::HTTP_OK
        );

        $this->assertTrue($this->sut->getResponseData()->getIsSuccessResponse());
    }

    public function testStaticInstanceWillReturnGivenStatusCode(): void
    {
        $this->sut = $this->createInstanceViaStaticMethod(null, null, [], Response::HTTP_UNAUTHORIZED);

        $this->assertInstanceOf(JsonResponseInterface::class, $this->sut);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $this->sut->getStatusCode());
    }

    /**
     * Overwrite parent's definition due to fixed default error message.
     */
    public function testStaticInstanceWillReturnNoDataWhenNoDataProvided(): void
    {
        $this->sut = $this->createInstanceViaStaticMethod();

        $this->assertInstanceOf(JsonResponseInterface::class, $this->sut);

        $this->assertNull($this->sut->getResponseData()->getResponseData()->getValue());
        $this->assertEquals(
            DefaultErrorResponse::DEFAULT_ERROR_MESSAGE,
            $this->sut->getResponseData()->getResponseError()->getValue()
        );
    }

    public function testCreateFromExceptionReturnsJsonResponseInterface(): void
    {
        $this->sut = DefaultErrorResponse::createFromException(new Exception());

        $this->assertInstanceOf(JsonResponseInterface::class, $this->sut);
    }

    public function testCreateFromExceptionReturnsMessageFromException(): void
    {
        $this->sut = DefaultErrorResponse::createFromException(
            new Exception(self::EXCEPTION_CONTENT_TEXT)
        );

        $this->assertEquals(
            self::EXCEPTION_CONTENT_TEXT,
            $this->sut->getResponseData()->getResponseError()->getValue()
        );
    }

    public function testCreateFromExceptionReturnsExceptionStatusCodeWhenNoCustomProvided(): void
    {
        $this->sut = DefaultErrorResponse::createFromException(
            new Exception(
                self::EXCEPTION_CONTENT_TEXT,
                Response::HTTP_INTERNAL_SERVER_ERROR
            )
        );

        $this->assertEquals(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $this->sut->getStatusCode()
        );
    }

    public function testCreateFromExceptionReturnsProvidedCustomStatusCodeWhenNoCodeGivenToException(): void
    {
        $this->sut = DefaultErrorResponse::createFromException(
            new Exception(),
            [],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        $this->assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $this->sut->getStatusCode()
        );
    }

    public function testCreateFromExceptionCustomStatusCodeTakesPriority(): void
    {
        $this->sut = DefaultErrorResponse::createFromException(
            new Exception('', Response::HTTP_INTERNAL_SERVER_ERROR),
            [],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        $this->assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $this->sut->getStatusCode()
        );

    }

    protected function createInstanceViaStaticMethod(
        ?array $data = null,
        mixed $error = null,
        array $headers = [],
        ?int $customStatusCode = null,
    ): JsonResponseInterface {
        return DefaultErrorResponse::create($data, $error, $headers, $customStatusCode);
    }

}
