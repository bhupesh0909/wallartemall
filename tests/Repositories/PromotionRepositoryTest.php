<?php namespace Tests\Repositories;

use App\Models\Promotion;
use App\Repositories\PromotionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PromotionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PromotionRepository
     */
    protected $promotionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->promotionRepo = \App::make(PromotionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_promotion()
    {
        $promotion = factory(Promotion::class)->make()->toArray();

        $createdPromotion = $this->promotionRepo->create($promotion);

        $createdPromotion = $createdPromotion->toArray();
        $this->assertArrayHasKey('id', $createdPromotion);
        $this->assertNotNull($createdPromotion['id'], 'Created Promotion must have id specified');
        $this->assertNotNull(Promotion::find($createdPromotion['id']), 'Promotion with given id must be in DB');
        $this->assertModelData($promotion, $createdPromotion);
    }

    /**
     * @test read
     */
    public function test_read_promotion()
    {
        $promotion = factory(Promotion::class)->create();

        $dbPromotion = $this->promotionRepo->find($promotion->id);

        $dbPromotion = $dbPromotion->toArray();
        $this->assertModelData($promotion->toArray(), $dbPromotion);
    }

    /**
     * @test update
     */
    public function test_update_promotion()
    {
        $promotion = factory(Promotion::class)->create();
        $fakePromotion = factory(Promotion::class)->make()->toArray();

        $updatedPromotion = $this->promotionRepo->update($fakePromotion, $promotion->id);

        $this->assertModelData($fakePromotion, $updatedPromotion->toArray());
        $dbPromotion = $this->promotionRepo->find($promotion->id);
        $this->assertModelData($fakePromotion, $dbPromotion->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_promotion()
    {
        $promotion = factory(Promotion::class)->create();

        $resp = $this->promotionRepo->delete($promotion->id);

        $this->assertTrue($resp);
        $this->assertNull(Promotion::find($promotion->id), 'Promotion should not exist in DB');
    }
}
