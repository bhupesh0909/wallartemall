<?php namespace Tests\Repositories;

use App\Models\GameType;
use App\Repositories\GameTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class GameTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var GameTypeRepository
     */
    protected $gameTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->gameTypeRepo = \App::make(GameTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_game_type()
    {
        $gameType = factory(GameType::class)->make()->toArray();

        $createdGameType = $this->gameTypeRepo->create($gameType);

        $createdGameType = $createdGameType->toArray();
        $this->assertArrayHasKey('id', $createdGameType);
        $this->assertNotNull($createdGameType['id'], 'Created GameType must have id specified');
        $this->assertNotNull(GameType::find($createdGameType['id']), 'GameType with given id must be in DB');
        $this->assertModelData($gameType, $createdGameType);
    }

    /**
     * @test read
     */
    public function test_read_game_type()
    {
        $gameType = factory(GameType::class)->create();

        $dbGameType = $this->gameTypeRepo->find($gameType->id);

        $dbGameType = $dbGameType->toArray();
        $this->assertModelData($gameType->toArray(), $dbGameType);
    }

    /**
     * @test update
     */
    public function test_update_game_type()
    {
        $gameType = factory(GameType::class)->create();
        $fakeGameType = factory(GameType::class)->make()->toArray();

        $updatedGameType = $this->gameTypeRepo->update($fakeGameType, $gameType->id);

        $this->assertModelData($fakeGameType, $updatedGameType->toArray());
        $dbGameType = $this->gameTypeRepo->find($gameType->id);
        $this->assertModelData($fakeGameType, $dbGameType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_game_type()
    {
        $gameType = factory(GameType::class)->create();

        $resp = $this->gameTypeRepo->delete($gameType->id);

        $this->assertTrue($resp);
        $this->assertNull(GameType::find($gameType->id), 'GameType should not exist in DB');
    }
}
