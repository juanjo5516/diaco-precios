<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UomCodePublic extends TransformerAbstract
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
    public function transform($collect)
    {
        return [
            'code'          => $collect->idMedida,
            'name'          => $collect->medida,
            'latestDate'    => $collect->fecha_actual,
            'latestPrice'   => $collect->Precio_actual,
            'previousDate'  => $collect->fecha_anterior,
            'previousPrice' => $collect->precio_anterior,
        ];
    }
}
