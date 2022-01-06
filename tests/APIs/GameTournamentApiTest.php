<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\GameTournament;

class GameTournamentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/game_tournaments', $gameTournament
        );

        $this->assertApiResponse($gameTournament);
    }

    /**
     * @test
     */
    public function test_read_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/game_tournaments/'.$gameTournament->id
        );

        $this->assertApiResponse($gameTournament->toArray());
    }

    /**
     * @test
     */
    public function test_update_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->create();
        $editedGameTournament = factory(GameTournament::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/game_tournaments/'.$gameTournament->id,
            $editedGameTournament
        );

        $this->assertApiResponse($editedGameTournament);
    }

    /**
     * @test
     */
    public function test_delete_game_tournament()
    {
        $gameTournament = factory(GameTournament::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/game_tournaments/'.$gameTournament->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/game_tournaments/'.$gameTournament->id
        );

        $this->response->assertStatus(404);
    }
}
