<?php

namespace Tests\Unit\CQ\Commands\Command\BlogPost;

use App\CQ\Commands\Command\BlogPost\UpsertBlogPostCommand;
use App\Models\BlogPost;
use Tests\TestCase;

class UpsertBlogPostCommandTest extends TestCase
{
    public const MOCK_TITLE = 'title';
    public const MOCK_EXCERPT = 'excerpt';
    public const MOCK_CATEGORY_ID = 1;
    public const MOCK_CONTENT = '<section>content</section>';
    public const MOCK_IS_ACTIVE = true;
    public const MOCK_IS_RESTRICTED = false;

    private UpsertBlogPostCommand $sut;

    public function setUp(): void
    {
        $this->sut = $this->getSutInstanceWithMockedData();

        parent::setUp();
    }

    public function testGettersReturnValuesProvidedInConstructor(): void
    {
        $this->assertEquals(
            self::MOCK_TITLE,
            $this->sut->getTitle()
        );
        $this->assertEquals(
            self::MOCK_EXCERPT,
            $this->sut->getExcerpt()
        );
        $this->assertEquals(
            self::MOCK_CATEGORY_ID,
            $this->sut->getCategoryId()
        );
        $this->assertEquals(
            self::MOCK_CONTENT,
            $this->sut->getContent()
        );
        $this->assertEquals(
            self::MOCK_IS_ACTIVE,
            $this->sut->getIsActive()
        );
        $this->assertEquals(
            self::MOCK_IS_RESTRICTED,
            $this->sut->getIsRestricted()
        );
    }

    public function testToAssocArrayReturnsArrayWithExpectedKeysAndValuesFromConstructor(): void
    {
        $this->assertEquals(
            [
                BlogPost::COLUMN_TITLE => self::MOCK_TITLE,
                BlogPost::COLUMN_EXCERPT => self::MOCK_EXCERPT,
                BlogPost::COLUMN_CATEGORY_ID => self::MOCK_CATEGORY_ID,
                BlogPost::COLUMN_CONTENT => self::MOCK_CONTENT,
                BlogPost::COLUMN_IS_ACTIVE => self::MOCK_IS_ACTIVE,
                BlogPost::COLUMN_IS_RESTRICTED => self::MOCK_IS_RESTRICTED,
            ],
            $this->sut->toAssocArray()
        );
    }

    public function getSutInstanceWithMockedData(): UpsertBlogPostCommand
    {
        return new UpsertBlogPostCommand(
            self::MOCK_TITLE,
            self::MOCK_EXCERPT,
            self::MOCK_CATEGORY_ID,
            self::MOCK_CONTENT,
            self::MOCK_IS_ACTIVE,
            self::MOCK_IS_RESTRICTED,
        );
    }
}
