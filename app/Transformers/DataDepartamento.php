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
        // dd($data);
        return [
            'code'          =>  $data['code'],
            'name'          =>  $data['name'],
            // 'branches'      =>  fractal($data['sedes'], new dataSede()),
            'branches'      =>  [
                
                                    fractal()->collection($data['sedes'])
                                    ->transformWith(new dataSede())
                                    ->includeCharacters()
                                    ->toArray(),
                            'categories'        =>  fractal($data['categorias'], new categories())  
                            ]
            
        ];
    }
}
