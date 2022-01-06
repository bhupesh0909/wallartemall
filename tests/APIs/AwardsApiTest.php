<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Awards;

class AwardsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_awards()
    {
        $awards = factory(Awards::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/awards', $awards
        );

        $this->assertApiResponse($awards);
    }

    /**
     * @test
     */
    public function test_read_awards()
    {
        $awards = factory(Awards::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/awards/'.$awards->id
        );

        $this->assertApiResponse($awards->toArray());
    }

    /**
     * @test
     */
    public function test_update_awards()
    {
        $awards = factory(Awards::class)->create();
        $editedAwards = factory(Awards::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/awards/'.$awards->id,
            $editedAwards
        );

        $this->assertApiResponse($editedAwards);
    }

    /**
     * @test
     */
    public function test_delete_awards()
    {
        $awards = factory(Awards::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/awards/'.$awards->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/awards/'.$awards->id
        );

        $this->response->assertStatus(404);
    }
}
