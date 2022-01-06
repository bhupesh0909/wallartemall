<?php

namespace App\Repositories;

use App\Models\TournamentType;
use App\Repositories\BaseRepository;

/**
 * Class TournamentTypeRepository
 * @package App\Repositories
 * @version December 1, 2019, 4:29 am UTC
*/

class TournamentTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tournament_type',
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
        return TournamentType::class;
    }
}
