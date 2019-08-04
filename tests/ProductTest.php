<?php

class ProductTest extends TestCase
{    
    /**
     * All products test.
     *
     * @return void
     */
    public function testAllProducts()
    {
        $response = $this->get('/products');       
        $response->assertResponseStatus(
            $response->response->getStatusCode()
        );                 
    }

    /**
     * User products test.
     *
     * @return void
     */
    public function testUserProducts()
    {        
        $response = $this->get('/user/products', 
                        ['Authorization' => AUTH_TOKEN]
                    );                
        $response->assertResponseStatus(
            $response->response->getStatusCode()
        );         
    }

    /**
     * User create product test.
     * 
     * @return void
     */
    public function testUserCreateProduct()
    {        
        $response = $this->post('/user/products', 
                        ["name" => "test 123"], 
                        ['Authorization' => AUTH_TOKEN]
                    );              
        $response->assertResponseStatus(
            $response->response->getStatusCode()
        );  
    }

    /**
     * User delete product test.
     * 
     * @return void
     */
    public function testUserDeleteProduct()
    {             
        $response = $this->delete('/user/products/test-123', 
                        ['Authorization' => AUTH_TOKEN]
                    );        
        $response->assertResponseStatus(
            $response->response->getStatusCode()
        );
    }
}