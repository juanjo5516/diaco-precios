<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;

class PricesData extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    
    
     
     public function transform($last)
    {

        return [
            'code' => $last['code'],
            'name' => $last['name'],
            'uom'  => fractal($last['uom'], new UomCodeTransformer())
            

            // 'uom'  => [
            //     'code' => fractal($last['uom'], new UomCodeTransformer())
            // ]
                        
        ];
    }
}
