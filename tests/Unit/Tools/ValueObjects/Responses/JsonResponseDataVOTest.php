<?php

namespace Tests\Unit\Tools\ValueObjects\Responses;

use App\Interfaces\Responses\ResponseDataValueObjectInterface as ResponseDataInterface;
use App\Tools\ValueObjects\Responses\JsonResponseDataVO as JsonResponseData;
use Tests\TestCase;

class JsonResponseDataVOTest extends TestCase
{
    public const SAMPLE_RESPONSE_CONTENT = [
        'testKey' => 'test value',
    ];

    protected ResponseDataInterface $sut;

    public function testObjectIsInstanceOfCorrectInterface(): void
    {
        $this->sut = new JsonResponseData;

        $this->assertInstanceOf(ResponseDataInterface::class, $this->sut);
    }

    public function testInstanceReturnsNullWhenNoValueProvidedInConstructor(): void
    {
        $this->sut = new JsonResponseData;

        $this->assertNull($this->sut->getValue());
    }

    public function testInstanceReturnsProvidedDataInConstructor(): void
    {
        $this->sut = new JsonResponseData(self::SAMPLE_RESPONSE_CONTENT);

        $this->assertEquals(self::SAMPLE_RESPONSE_CONTENT, $this->sut->getValue());
    }
}
