<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testSearch()
    {
        Product::factory()->create(['category' => 'sandals']);
        Product::factory()->count(2)->create(['category' => 'boots']);

        $this->assertCount(0, Product::search(['category' => 'Anakin'])->get());
        $this->assertCount(1, Product::search(['category' => 'sandals'])->get());
        $this->assertCount(2, Product::search(['category' => 'boots'])->get());
    }

    public function testSearchByCategoryProducts()
    {
        Product::factory()->count(2)->create(['category' => 'sandals']);
        Product::factory()->count(2)->create(['category' => 'boots']);

        $response = $this->getJson(route('products.index',['category' => 'sandals']))->assertOk()->json('data');

        $this->assertCount(2, $response);
    }

    public function testSearchByPriceProducts()
    {
        Product::factory()->count(2)->create(['price' => '23400']);
        Product::factory()->count(2)->create(['price' => '25000']);
        Product::factory()->count(2)->create(['price' => '25001']);

        $response = $this->getJson(route('products.index',['priceLessThan' => '25000']))->assertOk()->json('data');

        $this->assertCount(4, $response);
        $this->assertLessThanOrEqual(25000, $response[0]['price']['original']);
    }

    public function testProductSkuDiscounts()
    {
        Product::factory()->create(['sku' => '000003', 'category' => 'sandals']);
        Product::factory()->count(2)->create(['category' => 'boots']);

        $response = $this->getJson(route('products.index',['category' => 'sandals']))->assertOk()->json('data');

        $this->assertEquals('15%', $response[0]['price']['discount_percentage']);
    }

    public function testProductCategoryDiscounts()
    {
        Product::factory()->create(['category' => 'boots']);

        $response = $this->getJson(route('products.index',['category' => 'boots']))->assertOk()->json('data');

        $this->assertEquals('30%', $response[0]['price']['discount_percentage']);
    }

    public function testProductMaxDiscounts()
    {
        Product::factory()->create(['sku' => '000003', 'category' => 'boots']);

        $response = $this->getJson(route('products.index',['category' => 'boots']))->assertOk()->json('data');

        $this->assertEquals('30%', $response[0]['price']['discount_percentage']);
        $this->assertGreaterThan($response[0]['price']['final'], $response[0]['price']['original']);
    }

    public function testProductPriceWithoutDiscounts()
    {
        Product::factory()->create(['sku' => '000002', 'category' => 'sandals']);

        $response = $this->getJson(route('products.index'))->assertOk()->json('data');

        $this->assertNull($response[0]['price']['discount_percentage']);
        $this->assertEquals($response[0]['price']['original'], $response[0]['price']['final']);
    }

    public function test20000Products()
    {
        Product::factory()->count(20)->create();

        $response = $this->getJson(route('products.index'))->assertOk()->json('data');

        $this->assertCount(5, $response);
    }
}
