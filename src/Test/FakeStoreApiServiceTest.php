<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Connectors\FakeStoreApi\FakeStoreApiService;

class FakeStoreApiServiceTest extends TestCase
{
    public function testConnection()
    {
        $service = new FakeStoreApiService();
        $this->assertTrue($service->check_connection());
    }

    public function testGetProducts()
    {
        $service = new FakeStoreApiService();
        $products = $service->getProducts();
        $this->assertNotEmpty($products);
    }

    public function testGetProductById()
    {
        $service = new FakeStoreApiService();
        $productId =rand(1, 10);
        $product = $service->getProductById($productId);
        $this->assertNotNull($product);

    }
}