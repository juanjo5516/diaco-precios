<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PublicDepartament extends TransformerAbstract 
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
            'code'          =>  $data['code'],
            'name'          =>  $data['name'],
            // 'branches'      =>  fractal($data['sedes'], new dataSede()),
            'branches'      =>  fractal($data['sedes'], new PublicSede())->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                   
                                    // fractal()->collection($data['sedes'])
                                    // ->transformWith(new PublicSede())
                                    // ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                    // ->toArray()
                            
        ];
    }
}
