<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Promotion;

class PromotionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_promotion()
    {
        $promotion = factory(Promotion::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/promotions', $promotion
        );

        $this->assertApiResponse($promotion);
    }

    /**
     * @test
     */
    public function test_read_promotion()
    {
        $promotion = factory(Promotion::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/promotions/'.$promotion->id
        );

        $this->assertApiResponse($promotion->toArray());
    }

    /**
     * @test
     */
    public function test_update_promotion()
    {
        $promotion = factory(Promotion::class)->create();
        $editedPromotion = factory(Promotion::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/promotions/'.$promotion->id,
            $editedPromotion
        );

        $this->assertApiResponse($editedPromotion);
    }

    /**
     * @test
     */
    public function test_delete_promotion()
    {
        $promotion = factory(Promotion::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/promotions/'.$promotion->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/promotions/'.$promotion->id
        );

        $this->response->assertStatus(404);
    }
}
