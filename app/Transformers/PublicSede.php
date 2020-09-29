<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PublicSede extends TransformerAbstract
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
            
                'code'              =>  $data['code'], 
                'name'              =>  $data['name'],
                'depto'             =>  $data['departamento'],
                'latitude'          =>  $data['latitude'],
                'longitude'         =>  $data['longitude'],
                'categories'        =>  fractal($data['categories'], new PublicCategorias())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())  
            
        ];
    }

}
