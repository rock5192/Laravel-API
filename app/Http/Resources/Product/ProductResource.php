<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
           'name' => $this->name,
           'description' => $this->detail,
           'price' => $this->price,
            'discount' => $this->discount,
            'total_price' => ($this->price - ($this->discount/100)*($this->price)),
            'stock' => $this->stock ==0 ? 'Out of stock' : $this->stock,
            'rating' => $this->reviews->count()>0
                ? round($this->reviews->sum('star')/$this->reviews->count(),2)
                : 'No rating yet',
            'href' => [
                'reviews' => route('reviews.index',$this->id)
            ],



        ];
    }
}