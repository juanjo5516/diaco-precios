<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\TransformerParams;

class dataSede extends TransformerAbstract
{
    // public function __construct($categorias)
    // {
    //     $this->categorias = $categorias;
    // }


    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($data)
    {

        return [
            'data'  => [
                //'code'              =>  $data['dataS']->code,
                //'name'              =>  $data['dataS']->name,
                //'latitude'          =>  $data['dataS']->latitut,
                //'longitude'         =>  $data['dataS']->longitud,

                'code'              =>  $data['code'],
                'name'              =>  $data['name'],
                'latitude'          =>  $data['latitude'],
                'longitude'         =>  $data['longitude'],
                'categories'        =>  fractal($data['categories'], new categories())
            ],

        ];
    }
}
