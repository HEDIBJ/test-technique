<?php

namespace App\Connectors\FakeStoreApi;

use Symfony\Component\HttpClient\HttpClient;

class FakeStoreApiService
{
    private const ENDPOINT = 'https://fakestoreapi.com';
    private $isConnected;

    public function __construct()
    {
        $this->isConnected = $this->check_connection();
    }

    public function check_connection(): bool
    {
        $client = HttpClient::create();

        $response = $client->request('GET', self::ENDPOINT);

        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            return true;
        }
        return false;
    }

    public function getProducts(): array
    {
        if (!$this->isConnected) {
            return [];
        }

        $client = HttpClient::create();

        $response = $client->request('GET', self::ENDPOINT . '/products/');

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            return $response->toArray();
        }

        return [];
    }

    public function getProductById($productId): ?array
    {
        if (!$this->isConnected) {
            return [];
        }
        $client = HttpClient::create();

        $response = $client->request('GET', self::ENDPOINT . '/products/' . $productId);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            return $response->toArray();
        }

        return null;
    }


}