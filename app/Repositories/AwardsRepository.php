<?php

namespace App\Repositories;

use App\Models\Awards;
use App\Repositories\BaseRepository;

/**
 * Class AwardsRepository
 * @package App\Repositories
 * @version December 7, 2019, 1:16 pm UTC
*/

class AwardsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
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
        return Awards::class;
    }
}
