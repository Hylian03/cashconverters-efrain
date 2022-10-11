<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProductController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/product")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        ProductRepository $productRepository
    ) {
        // Al tener instalado Serializer, podemos devolver objetos tal cual.
        // (serializa los objetos en base a las definiciones yaml de /config/serializer/Entity)
        return $productRepository->findAll();
    }

    /**
     * @Rest\Post(path="/product")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        EntityManagerInterface $em
    ) {
        /**
         * POST de productos a través de API, no es necesario ya que no estaba en los requisitos de la prueba,
         * los productos se insertan a través del controlador Controller/ProductController.php
         */

        $response = new JsonResponse();
        return $response;
    }
}
