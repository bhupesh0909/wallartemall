<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TournamentType;

class TournamentTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/tournament_types', $tournamentType
        );

        $this->assertApiResponse($tournamentType);
    }

    /**
     * @test
     */
    public function test_read_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/tournament_types/'.$tournamentType->id
        );

        $this->assertApiResponse($tournamentType->toArray());
    }

    /**
     * @test
     */
    public function test_update_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->create();
        $editedTournamentType = factory(TournamentType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/tournament_types/'.$tournamentType->id,
            $editedTournamentType
        );

        $this->assertApiResponse($editedTournamentType);
    }

    /**
     * @test
     */
    public function test_delete_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/tournament_types/'.$tournamentType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/tournament_types/'.$tournamentType->id
        );

        $this->response->assertStatus(404);
    }
}
