<?php namespace Tests\Repositories;

use App\Models\SendInvitation;
use App\Repositories\SendInvitationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SendInvitationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SendInvitationRepository
     */
    protected $sendInvitationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->sendInvitationRepo = \App::make(SendInvitationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->make()->toArray();

        $createdSendInvitation = $this->sendInvitationRepo->create($sendInvitation);

        $createdSendInvitation = $createdSendInvitation->toArray();
        $this->assertArrayHasKey('id', $createdSendInvitation);
        $this->assertNotNull($createdSendInvitation['id'], 'Created SendInvitation must have id specified');
        $this->assertNotNull(SendInvitation::find($createdSendInvitation['id']), 'SendInvitation with given id must be in DB');
        $this->assertModelData($sendInvitation, $createdSendInvitation);
    }

    /**
     * @test read
     */
    public function test_read_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->create();

        $dbSendInvitation = $this->sendInvitationRepo->find($sendInvitation->id);

        $dbSendInvitation = $dbSendInvitation->toArray();
        $this->assertModelData($sendInvitation->toArray(), $dbSendInvitation);
    }

    /**
     * @test update
     */
    public function test_update_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->create();
        $fakeSendInvitation = factory(SendInvitation::class)->make()->toArray();

        $updatedSendInvitation = $this->sendInvitationRepo->update($fakeSendInvitation, $sendInvitation->id);

        $this->assertModelData($fakeSendInvitation, $updatedSendInvitation->toArray());
        $dbSendInvitation = $this->sendInvitationRepo->find($sendInvitation->id);
        $this->assertModelData($fakeSendInvitation, $dbSendInvitation->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_send_invitation()
    {
        $sendInvitation = factory(SendInvitation::class)->create();

        $resp = $this->sendInvitationRepo->delete($sendInvitation->id);

        $this->assertTrue($resp);
        $this->assertNull(SendInvitation::find($sendInvitation->id), 'SendInvitation should not exist in DB');
    }
}
