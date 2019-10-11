<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'aname' => $this->aname, // %TODO: renderField(), or does this belong in view layer?
            'adesc' => $this->adesc,
            'listings' => [],
        ];
    }
}
