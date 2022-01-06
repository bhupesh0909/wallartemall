<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\GameType;

class GameTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_game_type()
    {
        $gameType = factory(GameType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/game_types', $gameType
        );

        $this->assertApiResponse($gameType);
    }

    /**
     * @test
     */
    public function test_read_game_type()
    {
        $gameType = factory(GameType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/game_types/'.$gameType->id
        );

        $this->assertApiResponse($gameType->toArray());
    }

    /**
     * @test
     */
    public function test_update_game_type()
    {
        $gameType = factory(GameType::class)->create();
        $editedGameType = factory(GameType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/game_types/'.$gameType->id,
            $editedGameType
        );

        $this->assertApiResponse($editedGameType);
    }

    /**
     * @test
     */
    public function test_delete_game_type()
    {
        $gameType = factory(GameType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/game_types/'.$gameType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/game_types/'.$gameType->id
        );

        $this->response->assertStatus(404);
    }
}
