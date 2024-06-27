<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel,WithHeadingRow ,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $product_batch_id;

    public function __construct($product_batch_id)
    {
        $this->product_batch_id = $product_batch_id;
       
    }

    public function model(array $row)
    {
        return new Product([
            'product_batch_id'     =>  $this->product_batch_id,
            'product_name'     => $row['product_name'],
            'quantity'    => $row['quantity'], 
           'price_quantity' =>$row['price'],
            'description' => $row['description'],
        ]);
    }

    /**
     * Write code on Methodphp artisan make:controller UserController

     *
     * @return response()
     */
    public function rules(): array
    {
        return [
           
                'product_name' => ['required', 'string'],
                'quantity' => ['required', 'numeric'],
                'price' => ['required', 'numeric'],
                'description' => ['required', 'string'],
          
        ];
    }
}