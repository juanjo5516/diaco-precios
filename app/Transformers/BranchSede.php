<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Collection;

// use League\Fractal\paginatedCollection;

class BranchSede extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */


    public function transform($data)
    {
        dd($data);
        // $sedes = collection($data['sede']);
        // dd($sede);
        // $item = $this->includeAuthor($data);
        // dd($item->items);
        return [
            'data'              =>  fractal($data['sede'],new dataSede()),
            // 'data'              =>  fractal()->collection($data['sede'],$data['sede'])
            //                             ->transformWith(new dataSede($data['categoria']))
            //                             ->includeCharacters()
            //                             ->toArray(),
            // 'data'              =>  fractal()->paginatedCollection($data, new dataSede(['categoria' => $data])),
            // 'data'              =>  $item->data,
            // 'data'              =>  $data['sede'][0]->
            // 'categories'        =>  fractal($data['categoria'], new categories())         
        ];
    }


}
