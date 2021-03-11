<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/Mes-bijoux", name="products")
     */
    public function index(Request $request, ProductRepository $productRepository): Response
    {

        $products = $productRepository->findAll();


        return $this->render('product/index.html.twig', [
                'products' => $products,
            ]
        );
    }



    /**
     * @Route("/Mes-bijoux/{slug}", name="product")
     */
    public function show($slug): Response
    {

        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
                'product' => $product,
            ]
        );
    }
}
