<?php

namespace App\Repositories;

use App\Models\Promotion;
use App\Repositories\BaseRepository;

/**
 * Class PromotionRepository
 * @package App\Repositories
 * @version December 9, 2019, 6:41 pm UTC
 */
class PromotionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'promo_code',
        'description'
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
        return Promotion::class;
    }

    public function UpdatePromotionStatus($promo_id)
    {
        $get_promo_status = Promotion::where('id', $promo_id)->first();
        if ($get_promo_status->is_active == 1) {
            return Promotion::where('id', $promo_id)->update(['is_active' => '0']);
        } else {
            return Promotion::where('id', $promo_id)->update(['is_active' => '1']);
        }
    }


    public function CheckPromo($promo_code)
    {       
        return $get_promo_status = Promotion::where('promo_code', $promo_code)->first();
      
    }
}
