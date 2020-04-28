<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UomCodeTransformer extends TransformerAbstract
{
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
