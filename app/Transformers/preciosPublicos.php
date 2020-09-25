<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class preciosPublicos extends TransformerAbstract
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
    public function transform($last)
    {
        return [
            'code' => $last['code'],
            'name' => $last['name'],
            'uom'  => fractal($last['uom'], new UomCodePublic())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())  
        ];
    }
}
