<?php namespace Tests\Repositories;

use App\Models\Chip;
use App\Repositories\ChipRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ChipRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ChipRepository
     */
    protected $chipRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->chipRepo = \App::make(ChipRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_chip()
    {
        $chip = factory(Chip::class)->make()->toArray();

        $createdChip = $this->chipRepo->create($chip);

        $createdChip = $createdChip->toArray();
        $this->assertArrayHasKey('id', $createdChip);
        $this->assertNotNull($createdChip['id'], 'Created Chip must have id specified');
        $this->assertNotNull(Chip::find($createdChip['id']), 'Chip with given id must be in DB');
        $this->assertModelData($chip, $createdChip);
    }

    /**
     * @test read
     */
    public function test_read_chip()
    {
        $chip = factory(Chip::class)->create();

        $dbChip = $this->chipRepo->find($chip->id);

        $dbChip = $dbChip->toArray();
        $this->assertModelData($chip->toArray(), $dbChip);
    }

    /**
     * @test update
     */
    public function test_update_chip()
    {
        $chip = factory(Chip::class)->create();
        $fakeChip = factory(Chip::class)->make()->toArray();

        $updatedChip = $this->chipRepo->update($fakeChip, $chip->id);

        $this->assertModelData($fakeChip, $updatedChip->toArray());
        $dbChip = $this->chipRepo->find($chip->id);
        $this->assertModelData($fakeChip, $dbChip->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_chip()
    {
        $chip = factory(Chip::class)->create();

        $resp = $this->chipRepo->delete($chip->id);

        $this->assertTrue($resp);
        $this->assertNull(Chip::find($chip->id), 'Chip should not exist in DB');
    }
}
