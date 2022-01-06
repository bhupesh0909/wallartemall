<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

use App\User;

/**
 * Class TransactionRepository
 * @package App\Repositories
 * @version November 23, 2019, 4:42 am UTC
*/

class TransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'transaction_id',
        'amount',
        'date_time',
        'trans_type',
        'status'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
	 
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Transaction::class;
    }
}
