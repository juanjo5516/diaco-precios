<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\TransformerParams;

class dataSede extends TransformerAbstract
{
    // public function __construct($categorias)
    // {
    //     $this->categorias = $categorias;
    // }

    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($data)
    {
        // dd($this->clubId);
        
        return [
            'code'              =>  $data->code,
            'name'              =>  $data->name,
            'latitude'          =>  $data->latitut,
            'longitude'         =>  $data->longitud,
            
        ];
    }
}
