<?php namespace Tests\Repositories;

use App\Models\GameTournament;
use App\Repositories\GameTournamentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class GameTournamentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var GameTournamentRepository
     */
    protected $gameTournamentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->gameTournamentRepo = \App::make(GameTournamentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->make()->toArray();

        $createdGameTournament = $this->gameTournamentRepo->create($gameTournament);

        $createdGameTournament = $createdGameTournament->toArray();
        $this->assertArrayHasKey('id', $createdGameTournament);
        $this->assertNotNull($createdGameTournament['id'], 'Created GameTournament must have id specified');
        $this->assertNotNull(GameTournament::find($createdGameTournament['id']), 'GameTournament with given id must be in DB');
        $this->assertModelData($gameTournament, $createdGameTournament);
    }

    /**
     * @test read
     */
    public function test_read_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->create();

        $dbGameTournament = $this->gameTournamentRepo->find($gameTournament->id);

        $dbGameTournament = $dbGameTournament->toArray();
        $this->assertModelData($gameTournament->toArray(), $dbGameTournament);
    }

    /**
     * @test update
     */
    public function test_update_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->create();
        $fakeGameTournament = factory(GameTournament::class)->make()->toArray();

        $updatedGameTournament = $this->gameTournamentRepo->update($fakeGameTournament, $gameTournament->id);

        $this->assertModelData($fakeGameTournament, $updatedGameTournament->toArray());
        $dbGameTournament = $this->gameTournamentRepo->find($gameTournament->id);
        $this->assertModelData($fakeGameTournament, $dbGameTournament->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->create();

        $resp = $this->gameTournamentRepo->delete($gameTournament->id);

        $this->assertTrue($resp);
        $this->assertNull(GameTournament::find($gameTournament->id), 'GameTournament should not exist in DB');
    }
}
