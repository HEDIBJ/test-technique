<?php

namespace App\Controller;

use App\Connectors\FakeStoreApi\FakeStoreApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $fakeStoreApiService;

    public function __construct(FakeStoreApiService $fakeStoreApiService)
    {
        $this->fakeStoreApiService = $fakeStoreApiService;
    }

    /**
     * @Route("/product-with-id/{id}", name="products")
     */
    public function products($id): JsonResponse
    {
        $products = $this->fakeStoreApiService->getProductById($id);
        return $this->json($products);
    }

    /**
     * @Route("/product/{id}", name="app_product")
     */
    public function detail($id): Response
    {
        $product = $this->fakeStoreApiService->getProductById($id);

        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }
}
