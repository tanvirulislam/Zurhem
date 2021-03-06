<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\Resource;

class CategoryCollection extends Resource
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
            
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->category_slug,
            'href' => [
                'product_link' => route('product.show',$this->category_slug)
            ]
            
            ];
    }
}
