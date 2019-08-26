<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;

class DataDepartamento extends TransformerAbstract
{
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
            'branches'      =>  fractal($data['branches'], new BranchSede()),
            'categories'    =>  fractal($data['categories'], new categories()),
        ];
    }
}
