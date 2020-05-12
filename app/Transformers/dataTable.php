<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class dataTable extends TransformerAbstract
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
        $x = 0;
        return [
            'name'      => $data['code'],
            'code '     => fractal($data['uom'], new dataTableData()) 
            
        ];
    }
}
