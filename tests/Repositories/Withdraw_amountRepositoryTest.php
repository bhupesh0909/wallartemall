<?php namespace Tests\Repositories;

use App\Models\Withdraw_amount;
use App\Repositories\Withdraw_amountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class Withdraw_amountRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var Withdraw_amountRepository
     */
    protected $withdrawAmountRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->withdrawAmountRepo = \App::make(Withdraw_amountRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->make()->toArray();

        $createdWithdraw_amount = $this->withdrawAmountRepo->create($withdrawAmount);

        $createdWithdraw_amount = $createdWithdraw_amount->toArray();
        $this->assertArrayHasKey('id', $createdWithdraw_amount);
        $this->assertNotNull($createdWithdraw_amount['id'], 'Created Withdraw_amount must have id specified');
        $this->assertNotNull(Withdraw_amount::find($createdWithdraw_amount['id']), 'Withdraw_amount with given id must be in DB');
        $this->assertModelData($withdrawAmount, $createdWithdraw_amount);
    }

    /**
     * @test read
     */
    public function test_read_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->create();

        $dbWithdraw_amount = $this->withdrawAmountRepo->find($withdrawAmount->id);

        $dbWithdraw_amount = $dbWithdraw_amount->toArray();
        $this->assertModelData($withdrawAmount->toArray(), $dbWithdraw_amount);
    }

    /**
     * @test update
     */
    public function test_update_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->create();
        $fakeWithdraw_amount = factory(Withdraw_amount::class)->make()->toArray();

        $updatedWithdraw_amount = $this->withdrawAmountRepo->update($fakeWithdraw_amount, $withdrawAmount->id);

        $this->assertModelData($fakeWithdraw_amount, $updatedWithdraw_amount->toArray());
        $dbWithdraw_amount = $this->withdrawAmountRepo->find($withdrawAmount->id);
        $this->assertModelData($fakeWithdraw_amount, $dbWithdraw_amount->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_withdraw_amount()
    {
        $withdrawAmount = factory(Withdraw_amount::class)->create();

        $resp = $this->withdrawAmountRepo->delete($withdrawAmount->id);

        $this->assertTrue($resp);
        $this->assertNull(Withdraw_amount::find($withdrawAmount->id), 'Withdraw_amount should not exist in DB');
    }
}
