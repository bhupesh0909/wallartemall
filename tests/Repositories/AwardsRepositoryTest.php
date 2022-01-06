<?php namespace Tests\Repositories;

use App\Models\Awards;
use App\Repositories\AwardsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AwardsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AwardsRepository
     */
    protected $awardsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->awardsRepo = \App::make(AwardsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_awards()
    {
        $awards = factory(Awards::class)->make()->toArray();

        $createdAwards = $this->awardsRepo->create($awards);

        $createdAwards = $createdAwards->toArray();
        $this->assertArrayHasKey('id', $createdAwards);
        $this->assertNotNull($createdAwards['id'], 'Created Awards must have id specified');
        $this->assertNotNull(Awards::find($createdAwards['id']), 'Awards with given id must be in DB');
        $this->assertModelData($awards, $createdAwards);
    }

    /**
     * @test read
     */
    public function test_read_awards()
    {
        $awards = factory(Awards::class)->create();

        $dbAwards = $this->awardsRepo->find($awards->id);

        $dbAwards = $dbAwards->toArray();
        $this->assertModelData($awards->toArray(), $dbAwards);
    }

    /**
     * @test update
     */
    public function test_update_awards()
    {
        $awards = factory(Awards::class)->create();
        $fakeAwards = factory(Awards::class)->make()->toArray();

        $updatedAwards = $this->awardsRepo->update($fakeAwards, $awards->id);

        $this->assertModelData($fakeAwards, $updatedAwards->toArray());
        $dbAwards = $this->awardsRepo->find($awards->id);
        $this->assertModelData($fakeAwards, $dbAwards->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_awards()
    {
        $awards = factory(Awards::class)->create();

        $resp = $this->awardsRepo->delete($awards->id);

        $this->assertTrue($resp);
        $this->assertNull(Awards::find($awards->id), 'Awards should not exist in DB');
    }
}
