<?php

namespace Tests\Unit\CQ\Commands\Command\PostCategory;

use App\CQ\Commands\Command\PostCategory\DeletePostCategoryCommand;
use Tests\TestCase;

class DeletePostCategoryCommandTest extends TestCase
{
    public const MOCK_ID = 1;

    private DeletePostCategoryCommand $sut;

    public function testGetIdReturnsIdGivenInConstructor(): void
    {
        $this->sut = new DeletePostCategoryCommand( self::MOCK_ID );

        $this->assertEquals(self::MOCK_ID, $this->sut->getId());
    }
}
