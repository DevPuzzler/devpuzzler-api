<?php

namespace Tests\Unit\CQ\Commands\Command\BlogPost;

use App\CQ\Commands\Command\BlogPost\DeleteBlogPostCommand;
use Tests\TestCase;

class DeleteBlogPostCommandTest extends TestCase
{
    public const MOCK_ID = 1;

    private DeleteBlogPostCommand $sut;

    public function testGetIdReturnsIdGivenInConstructor(): void
    {
        $this->sut = new DeleteBlogPostCommand(self::MOCK_ID);

        $this->assertEquals(self::MOCK_ID, $this->sut->getId());
    }
}
