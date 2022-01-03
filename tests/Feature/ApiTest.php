<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_product()
    {
        $response = $this->get('/api/product');

        $response->assertStatus(200);
    }
    public function test_get_specified_product()
    {
        $response = $this->get('/api/product/1');

        $response->assertStatus(200);
    }
    public function test_post_product()
    {
        $response = $this->post('/api/product', [
            'product_name' => 'Some name',
            'product_price' => '2000',
            'image' => UploadedFile::fake()->image('test.jpg')
        ]);

        $response->assertStatus(201);
    }
    // this method below is worked if product exist
    // public function test_delete_product()
    // {
    //     $this->withoutExceptionHandling();

    //     $response = $this->delete('/api/product/10');

    //     $response->assertStatus(200);
    // }
}
