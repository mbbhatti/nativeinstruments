<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'sku';

    /**
     * Set table primary key auto-increment.
     *
     * @var string
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku', 
        'name'
    ];

    /**
     * Has relation with Products and user.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'purchaseds');
    }

    /**
     * Get products.
     *     
     * @return object    
     */
    public function getAllProducts()
    {
        $data =  Product::all(['sku', 'name']);
        
        return !empty($data) ? $data : false;
    }

    /**
     * Get user products.
     *     
     * @param  int   $id
     * @return array    
     */
    public function getUserProducts(int $id)
    {
        $products = User::find($id)->Products;
        $result = [];    

        foreach ($products as $product) {
            array_push($result, [
                'sku'  => $product->sku, 
                'name' => $product->name
            ]);
        }

        return $result;   
    }

    /**
     * Create product.
     *     
     * @param  int      $id
     * @param  string   $name
     * @return string    
     */
    public function createUserProduct(int $id, string $name)
    {
        $identifier = str_replace(' ', '-', strtolower($name));

        $product = new Product;
        $product->name = $name;
        $product->sku = $identifier;
        $product->save();

        $user = User::find($id);
        $user->products()->attach(['product_sku' => $identifier]); 

        return true; 
    }

    /**
     * delete product.
     *
     * @param  int      $id
     * @param  string   $sku
     * @return string    
     */
    public function deleteUserProduct(int $id, string $sku)
    {
        $user = User::find($id);
        $user->products()->detach(['product_sku' => $sku]);
        
        $product = Product::find($sku);
        if(!empty($product))
            return $product->delete(); 

        return false;
    }
}
