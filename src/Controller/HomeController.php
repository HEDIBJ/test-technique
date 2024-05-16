<?php

namespace App\Controller;

use App\Connectors\FakeStoreApi\FakeStoreApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $fakeStoreApiService;
    public function __construct(FakeStoreApiService $fakeStoreApiService){
        $this->fakeStoreApiService = $fakeStoreApiService;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $products =  $this->fakeStoreApiService->getProducts();
        return $this->render('home/index.html.twig', [
            'products' => $products]);
    }
}
