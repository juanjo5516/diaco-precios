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

        return [
            'code'      =>  $data->code,
            'name'      =>  $data->name
        ];
    }
}
