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

        //  $user = $this->getPriceLast(1,1);
        // $colecion = new Collection($user);
        // $collection = Collection::make($last);
        // $resource = json_encode($last);
        
        return [
                        'item' => $last->item
                        // 'medida' => $last['last']['oum'],
                        // 'fecha' => $last['last']['current_date']
                        // 'precio' => $last-price,
                        // 'otro' => $previous->price
                        
        ];
    }
}
