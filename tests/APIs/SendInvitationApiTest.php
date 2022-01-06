<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SendInvitation;

class SendInvitationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/send_invitations', $sendInvitation
        );

        $this->assertApiResponse($sendInvitation);
    }

    /**
     * @test
     */
    public function test_read_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/send_invitations/'.$sendInvitation->id
        );

        $this->assertApiResponse($sendInvitation->toArray());
    }

    /**
     * @test
     */
    public function test_update_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->create();
        $editedSendInvitation = factory(SendInvitation::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/send_invitations/'.$sendInvitation->id,
            $editedSendInvitation
        );

        $this->assertApiResponse($editedSendInvitation);
    }

    /**
     * @test
     */
    public function test_delete_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/send_invitations/'.$sendInvitation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/send_invitations/'.$sendInvitation->id
        );

        $this->response->assertStatus(404);
    }
}
