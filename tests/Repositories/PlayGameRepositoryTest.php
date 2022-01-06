<?php namespace Tests\Repositories;

use App\Models\PlayGame;
use App\Repositories\PlayGameRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PlayGameRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PlayGameRepository
     */
    protected $playGameRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->playGameRepo = \App::make(PlayGameRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_play_game()
    {
        $playGame = factory(PlayGame::class)->make()->toArray();

        $createdPlayGame = $this->playGameRepo->create($playGame);

        $createdPlayGame = $createdPlayGame->toArray();
        $this->assertArrayHasKey('id', $createdPlayGame);
        $this->assertNotNull($createdPlayGame['id'], 'Created PlayGame must have id specified');
        $this->assertNotNull(PlayGame::find($createdPlayGame['id']), 'PlayGame with given id must be in DB');
        $this->assertModelData($playGame, $createdPlayGame);
    }

    /**
     * @test read
     */
    public function test_read_play_game()
    {
        $playGame = factory(PlayGame::class)->create();

        $dbPlayGame = $this->playGameRepo->find($playGame->id);

        $dbPlayGame = $dbPlayGame->toArray();
        $this->assertModelData($playGame->toArray(), $dbPlayGame);
    }

    /**
     * @test update
     */
    public function test_update_play_game()
    {
        $playGame = factory(PlayGame::class)->create();
        $fakePlayGame = factory(PlayGame::class)->make()->toArray();

        $updatedPlayGame = $this->playGameRepo->update($fakePlayGame, $playGame->id);

        $this->assertModelData($fakePlayGame, $updatedPlayGame->toArray());
        $dbPlayGame = $this->playGameRepo->find($playGame->id);
        $this->assertModelData($fakePlayGame, $dbPlayGame->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_play_game()
    {
        $playGame = factory(PlayGame::class)->create();

        $resp = $this->playGameRepo->delete($playGame->id);

        $this->assertTrue($resp);
        $this->assertNull(PlayGame::find($playGame->id), 'PlayGame should not exist in DB');
    }
}
