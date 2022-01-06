<?php

namespace App\Repositories;

use App\Models\GameType;
use App\Repositories\BaseRepository;

/**
 * Class GameTypeRepository
 * @package App\Repositories
 * @version November 22, 2019, 4:14 am UTC
*/

class GameTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'game_type',
        'game_icon',
        'is_active'
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
        return GameType::class;
    }
}
