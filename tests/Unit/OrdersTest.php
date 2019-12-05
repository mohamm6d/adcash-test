<?php
namespace Test\Integrated;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Laravel');
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCreateOrderForm()
    {
        $response = $this->get('/orders/create');
        $response->assertStatus(200);
        $response->assertSeeText('Create New');
    }


    /**
     * check for search form
     *
     * @return void
     */
    public function testSearchForm()
    {
        $response = $this->get('/search', ['filter_name' => 'john']);
        $response->assertStatus(200);
        $response->assertSeeText('EUR');
    }


    /**
     * check for search form
     *
     * @return void
     */
    public function testCreateOrder()
    {
        $response = $this->post('/orders/add', ['user_id' => '1' ,'product_id' => '1' ,'qty' => 4]);

        $response->assertStatus(405);
        $response->assertSeeText('Order has been added to database');
    }
   

    /**
     * check for edit an order
     *
     * @return void
     */
    public function testEditOrder()
    {
        $response = $this->get('/orders/2/edit');
        $response->assertStatus(200);
        $response->assertSeeText('Qty:');
    }


   
}