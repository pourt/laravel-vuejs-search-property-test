<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'max_price' => $this->collection->max('price')
        ];
    }
}
