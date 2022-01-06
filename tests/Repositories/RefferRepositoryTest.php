<?php namespace Tests\Repositories;

use App\Models\Refer;
use App\Repositories\ReferRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RefferRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ReferRepository
     */
    protected $refferRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->refferRepo = \App::make(ReferRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_reffer()
    {
        $reffer = factory(Refer::class)->make()->toArray();

        $createdReffer = $this->refferRepo->create($reffer);

        $createdReffer = $createdReffer->toArray();
        $this->assertArrayHasKey('id', $createdReffer);
        $this->assertNotNull($createdReffer['id'], 'Created Refer must have id specified');
        $this->assertNotNull(Refer::find($createdReffer['id']), 'Refer with given id must be in DB');
        $this->assertModelData($reffer, $createdReffer);
    }

    /**
     * @test read
     */
    public function test_read_reffer()
    {
        $reffer = factory(Refer::class)->create();

        $dbReffer = $this->refferRepo->find($reffer->id);

        $dbReffer = $dbReffer->toArray();
        $this->assertModelData($reffer->toArray(), $dbReffer);
    }

    /**
     * @test update
     */
    public function test_update_reffer()
    {
        $reffer = factory(Refer::class)->create();
        $fakeReffer = factory(Refer::class)->make()->toArray();

        $updatedReffer = $this->refferRepo->update($fakeReffer, $reffer->id);

        $this->assertModelData($fakeReffer, $updatedReffer->toArray());
        $dbReffer = $this->refferRepo->find($reffer->id);
        $this->assertModelData($fakeReffer, $dbReffer->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_reffer()
    {
        $reffer = factory(Refer::class)->create();

        $resp = $this->refferRepo->delete($reffer->id);

        $this->assertTrue($resp);
        $this->assertNull(Refer::find($reffer->id), 'Refer should not exist in DB');
    }
}
