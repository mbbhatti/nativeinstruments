<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles product response for the application. 
    |
    */  
    
    /**
     * Use for product object.
     *
     * @var string
     */
    protected $product;

    /**
     * Create a new controller instance.
     *
     * @param  $user User object
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [            
            'name' => 'required|regex:/^[a-zA-Z0-9\s]+$/|unique:products'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Get all products.
     *
     * @return json
     */
    public function allProducts()
    {        
        // Return all products
        return response()->json([
            'products'  => $this->product->getAllProducts()
        ], 200);
    }

    /**
     * Get user products.
     *
     * @param  Request  $request
     * @return json
     */
    public function userProducts(Request $request)
    {   
        // Get user id from token
        $id = $request->auth->id;

        // Return all user products
        return response()->json([
            'products' => $this->product->getUserProducts($id)
        ], 200);        
    }

    /**
     * Create user product.
     *
     * @param  Request  $request
     * @return json
     */
    public function createProduct(Request $request)
    {   
        // Check validation        
        $validator = $this->validator($request->all());  
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }
        
        $id = $request->auth->id; // Get user id from token
        $name = $request->input('name'); // Get request name

        // Create product and return response
        if($this->product->createUserProduct($id, $name)) {            
            return response()->json([
                'success' => 'Product has been created.'
            ], 200); 
        }

        // Return error response
        return response()->json([
            'error' => 'No product created.'
        ], 400);
    }

    /**
     * Delete user product.
     *
     * @param  Request  $request
     * @return json
     */
    public function deleteProduct(Request $request, string $sku)
    {   
        // Get user id from token
        $id = $request->auth->id;

        // Delete product and return response
        if($this->product->deleteUserProduct($id, $sku)) {
            return response()->json([
                'success' => 'Product has been deleted.'
            ], 200);        
        }

        // Return error response
        return response()->json([
            'error' => 'No product found.'
        ], 400);
    }
}
