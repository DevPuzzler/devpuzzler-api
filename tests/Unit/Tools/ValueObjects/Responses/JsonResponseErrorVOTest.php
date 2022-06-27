<?php

namespace Tests\Unit\Tools\ValueObjects\Responses;

use App\Interfaces\Responses\ResponseErrorValueObjectInterface as ResponseErrorInterface;
use App\Tools\ValueObjects\Responses\JsonResponseErrorVO as JsonResponseError;
use Tests\TestCase;

class JsonResponseErrorVOTest extends TestCase
{
    public const ERROR_RESPONSE_SAMPLE_TEXT = 'Sample response error text.';
    public const ERROR_RESPONSE_SAMPLE_ARRAY = [
        'Sample response error array.',
    ];

    protected ResponseErrorInterface $sut;

    public function testObjectIsInstanceOfCorrectInterface(): void
    {
        $this->sut = new JsonResponseError();

        $this->assertInstanceOf(ResponseErrorInterface::class, $this->sut);
    }

    public function testGetResponseErrorReturnsNullWhenNoValueProvidedInConstructor(): void
    {
        $this->sut = new JsonResponseError();

        $this->assertNull($this->sut->getValue());
    }

    public function testGetResponseErrorReturnsProvidedStringInConstructor(): void
    {
        $this->sut = new JsonResponseError(self::ERROR_RESPONSE_SAMPLE_TEXT);

        $this->assertEquals(self::ERROR_RESPONSE_SAMPLE_TEXT, $this->sut->getValue());
    }

    public function testGetResponseErrorReturnsProvidedArrayInConstructor(): void
    {
        $this->sut = new JsonResponseError(self::ERROR_RESPONSE_SAMPLE_ARRAY);

        $this->assertEquals(self::ERROR_RESPONSE_SAMPLE_ARRAY, $this->sut->getValue());
    }
}
