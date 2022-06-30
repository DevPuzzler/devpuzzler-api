<?php

namespace Tests\Unit\CQ\Commands\Command\PostCategory;

use App\CQ\Commands\Command\PostCategory\UpsertPostCategoryCommand;
use App\Models\PostCategory;
use Tests\TestCase;

class UpsertPostCategoryCommandTest extends TestCase
{
    public const MOCK_NAME = 'name';
    public const MOCK_DESCRIPTION = 'description';

    private UpsertPostCategoryCommand $sut;

    public function setUp(): void
    {
        $this->sut = $this->getSutInstanceWithMockedData();

        parent::setUp();
    }

    public function testGettersReturnValuesProvidedInConstructor(): void
    {
        $this->assertEquals(
            self::MOCK_NAME,
            $this->sut->getName()
        );
        $this->assertEquals(
            self::MOCK_DESCRIPTION,
            $this->sut->getDescription()
        );
    }

    public function testToAssocArrayReturnsArrayWithExpectedKeysAndValuesFromConstructor(): void
    {
        $this->assertEquals(
            [
                PostCategory::COLUMN_NAME => self::MOCK_NAME,
                PostCategory::COLUMN_DESCRIPTION => self::MOCK_DESCRIPTION,
            ],
            $this->sut->toAssocArray()
        );
    }

    public function getSutInstanceWithMockedData(): UpsertPostCategoryCommand
    {
        return new UpsertPostCategoryCommand(
            self::MOCK_NAME,
            self::MOCK_DESCRIPTION,
        );
    }
}
