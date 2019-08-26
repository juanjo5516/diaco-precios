<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class categories extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($data)
    {
        
        // dd($data);
        return [
            'code'      =>  $data->idCategoria,
            'name'      =>  $data->nombre
        ];
    }
}
