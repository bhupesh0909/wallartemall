<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Withdraw_amount;

class Withdraw_amountApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/withdraw_amounts', $withdrawAmount
        );

        $this->assertApiResponse($withdrawAmount);
    }

    /**
     * @test
     */
    public function test_read_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/withdraw_amounts/'.$withdrawAmount->id
        );

        $this->assertApiResponse($withdrawAmount->toArray());
    }

    /**
     * @test
     */
    public function test_update_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->create();
        $editedWithdraw_amount = factory(Withdraw_amount::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/withdraw_amounts/'.$withdrawAmount->id,
            $editedWithdraw_amount
        );

        $this->assertApiResponse($editedWithdraw_amount);
    }

    /**
     * @test
     */
    public function test_delete_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/withdraw_amounts/'.$withdrawAmount->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/withdraw_amounts/'.$withdrawAmount->id
        );

        $this->response->assertStatus(404);
    }
}
