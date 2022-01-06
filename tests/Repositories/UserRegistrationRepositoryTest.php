<?php namespace Tests\Repositories;

use App\Models\UserRegistration;
use App\Repositories\UserRegistrationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserRegistrationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserRegistrationRepository
     */
    protected $userRegistrationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userRegistrationRepo = \App::make(UserRegistrationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_registration()
    {
        $userRegistration = factory(UserRegistration::class)->make()->toArray();

        $createdUserRegistration = $this->userRegistrationRepo->create($userRegistration);

        $createdUserRegistration = $createdUserRegistration->toArray();
        $this->assertArrayHasKey('id', $createdUserRegistration);
        $this->assertNotNull($createdUserRegistration['id'], 'Created UserRegistration must have id specified');
        $this->assertNotNull(UserRegistration::find($createdUserRegistration['id']), 'UserRegistration with given id must be in DB');
        $this->assertModelData($userRegistration, $createdUserRegistration);
    }

    /**
     * @test read
     */
    public function test_read_user_registration()
    {
        $userRegistration = factory(UserRegistration::class)->create();

        $dbUserRegistration = $this->userRegistrationRepo->find($userRegistration->id);

        $dbUserRegistration = $dbUserRegistration->toArray();
        $this->assertModelData($userRegistration->toArray(), $dbUserRegistration);
    }

    /**
     * @test update
     */
    public function test_update_user_registration()
    {
        $userRegistration = factory(UserRegistration::class)->create();
        $fakeUserRegistration = factory(UserRegistration::class)->make()->toArray();

        $updatedUserRegistration = $this->userRegistrationRepo->update($fakeUserRegistration, $userRegistration->id);

        $this->assertModelData($fakeUserRegistration, $updatedUserRegistration->toArray());
        $dbUserRegistration = $this->userRegistrationRepo->find($userRegistration->id);
        $this->assertModelData($fakeUserRegistration, $dbUserRegistration->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_registration()
    {
        $userRegistration = factory(UserRegistration::class)->create();

        $resp = $this->userRegistrationRepo->delete($userRegistration->id);

        $this->assertTrue($resp);
        $this->assertNull(UserRegistration::find($userRegistration->id), 'UserRegistration should not exist in DB');
    }
}
