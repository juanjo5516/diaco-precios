<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;


class reportTransformer extends TransformerAbstract
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
            'name'      =>      $data['name'],
            'items'     =>      fractal($data['items'], new uom_data())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())  
            // fractal()->collection($filter_name)->transformWith(new reportTransformer())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
        ];
    }
}
