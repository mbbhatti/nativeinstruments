<?php

class UserTest extends TestCase
{    
    /**
     * Auth success test.
     *
     * @return void
     */
    public function testAuthSuccess()
    {
        $response = $this->post('/auth', 
                        ["email" => "kontakt@gmail.com"]
                    );        
        $response->assertResponseStatus(
            $response->response->getStatusCode()
        );                 
    }

    /**
     * Auth error test.
     *
     * @return void
     */
    public function testAuthError()
    {
        $response = $this->post('/auth', 
                        ["email" => "email@xyz.com"]
                    );
        $response->assertResponseStatus(
            $response->response->getStatusCode()
        );             
    }

    /**
     * User Detail test.
     * 
     * @return void
     */
    public function testUserDetail()
    {        
        $response = $this->get('/user', 
                        ['Authorization' => AUTH_TOKEN]
                    );        
        $response->assertResponseStatus(
            $response->response->getStatusCode()
        ); 
    }
}