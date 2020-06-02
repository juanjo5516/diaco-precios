<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class uom_data extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($data)
    {
        return [
            'product'      =>      $data->producto,
            'measure'      =>      $data->medida,
            'price'        =>      $data->precio
        ];
    }
}
