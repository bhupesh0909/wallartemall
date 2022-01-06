<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Chip;

class ChipApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_chip()
    {
        $chip = factory(Chip::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/chips', $chip
        );

        $this->assertApiResponse($chip);
    }

    /**
     * @test
     */
    public function test_read_chip()
    {
        $chip = factory(Chip::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/chips/'.$chip->id
        );

        $this->assertApiResponse($chip->toArray());
    }

    /**
     * @test
     */
    public function test_update_chip()
    {
        $chip = factory(Chip::class)->create();
        $editedChip = factory(Chip::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/chips/'.$chip->id,
            $editedChip
        );

        $this->assertApiResponse($editedChip);
    }

    /**
     * @test
     */
    public function test_delete_chip()
    {
        $chip = factory(Chip::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/chips/'.$chip->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/chips/'.$chip->id
        );

        $this->response->assertStatus(404);
    }
}
