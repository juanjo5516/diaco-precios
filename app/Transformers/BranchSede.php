<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BranchSede extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($data)
    {
        
        return [
            'code'      =>  $data->code,    
            'name'      =>  $data->name,
            'latitude'  =>  $data->latitut,
            'longitude' =>  $data->longitud
        ];
    }
}
