<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  $this->id,
            'fullName' =>  $this->firstName . ' ' . $this->lastName,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'company_id' => $this->company_id,

            'email' => $this->email,
            'phone' => $this->phone,

            // relasi
            'company_name' => $this->Company?->name,
            'company' => $this->Company,
        ];
    }
}
