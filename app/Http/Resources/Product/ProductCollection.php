<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = [];


        foreach($this->collection as $product)
        {
            array_push($products,[
               'name' => $product->name,
               'total_price' =>  round($product->price - ($product->discount/100)*($product->price),2),
                'discount' => $product->discount,
                'rating' => $product->reviews->count() > 0
                    ? round($product->reviews->sum('star')/$product->reviews->count(),2)
                    : 'No rating yet',
                'href' => [
                    'link' => route('products.show',$product->id)
                ],
            ]);
        }

        return $products;

    }
}
