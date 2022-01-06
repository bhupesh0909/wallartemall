<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PlayGame;

class PlayGameApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_play_game()
    {
        $playGame = factory(PlayGame::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/play_games', $playGame
        );

        $this->assertApiResponse($playGame);
    }

    /**
     * @test
     */
    public function test_read_play_game()
    {
        $playGame = factory(PlayGame::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/play_games/'.$playGame->id
        );

        $this->assertApiResponse($playGame->toArray());
    }

    /**
     * @test
     */
    public function test_update_play_game()
    {
        $playGame = factory(PlayGame::class)->create();
        $editedPlayGame = factory(PlayGame::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/play_games/'.$playGame->id,
            $editedPlayGame
        );

        $this->assertApiResponse($editedPlayGame);
    }

    /**
     * @test
     */
    public function test_delete_play_game()
    {
        $playGame = factory(PlayGame::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/play_games/'.$playGame->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/play_games/'.$playGame->id
        );

        $this->response->assertStatus(404);
    }
}
