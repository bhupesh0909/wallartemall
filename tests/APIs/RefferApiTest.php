<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Refer;

class RefferApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_reffer()
    {
        $reffer = factory(Refer::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/refers', $reffer
        );

        $this->assertApiResponse($reffer);
    }

    /**
     * @test
     */
    public function test_read_reffer()
    {
        $reffer = factory(Refer::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/refers/'.$reffer->id
        );

        $this->assertApiResponse($reffer->toArray());
    }

    /**
     * @test
     */
    public function test_update_reffer()
    {
        $reffer = factory(Refer::class)->create();
        $editedReffer = factory(Refer::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/refers/'.$reffer->id,
            $editedReffer
        );

        $this->assertApiResponse($editedReffer);
    }

    /**
     * @test
     */
    public function test_delete_reffer()
    {
        $reffer = factory(Refer::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/refers/'.$reffer->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/refers/'.$reffer->id
        );

        $this->response->assertStatus(404);
    }
}
