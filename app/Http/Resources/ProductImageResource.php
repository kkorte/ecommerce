<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductImageResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'file'       => $this->file,
            'url'        => sprintf('%s/files/product/800x800/%d/%s', config()->get('app.url'), $this->product_id, $this->file),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
