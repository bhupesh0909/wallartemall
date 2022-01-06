<?php namespace Tests\Repositories;

use App\Models\TournamentType;
use App\Repositories\TournamentTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TournamentTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TournamentTypeRepository
     */
    protected $tournamentTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->tournamentTypeRepo = \App::make(TournamentTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->make()->toArray();

        $createdTournamentType = $this->tournamentTypeRepo->create($tournamentType);

        $createdTournamentType = $createdTournamentType->toArray();
        $this->assertArrayHasKey('id', $createdTournamentType);
        $this->assertNotNull($createdTournamentType['id'], 'Created TournamentType must have id specified');
        $this->assertNotNull(TournamentType::find($createdTournamentType['id']), 'TournamentType with given id must be in DB');
        $this->assertModelData($tournamentType, $createdTournamentType);
    }

    /**
     * @test read
     */
    public function test_read_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->create();

        $dbTournamentType = $this->tournamentTypeRepo->find($tournamentType->id);

        $dbTournamentType = $dbTournamentType->toArray();
        $this->assertModelData($tournamentType->toArray(), $dbTournamentType);
    }

    /**
     * @test update
     */
    public function test_update_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->create();
        $fakeTournamentType = factory(TournamentType::class)->make()->toArray();

        $updatedTournamentType = $this->tournamentTypeRepo->update($fakeTournamentType, $tournamentType->id);

        $this->assertModelData($fakeTournamentType, $updatedTournamentType->toArray());
        $dbTournamentType = $this->tournamentTypeRepo->find($tournamentType->id);
        $this->assertModelData($fakeTournamentType, $dbTournamentType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tournament_type()
    {
        $tournamentType = factory(TournamentType::class)->create();

        $resp = $this->tournamentTypeRepo->delete($tournamentType->id);

        $this->assertTrue($resp);
        $this->assertNull(TournamentType::find($tournamentType->id), 'TournamentType should not exist in DB');
    }
}
