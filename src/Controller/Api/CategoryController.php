<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Status;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/category")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        CategoryRepository $categoryRepository
    ) {
        // Al tener instalado Serializer, podemos devolver objetos tal cual.
        // (serializa los objetos en base a las definiciones yaml de /config/serializer/Entity)
        return $categoryRepository->findAll();
    }

    /**
     * @Rest\Post(path="/category")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        EntityManagerInterface $em
    ) {
        /**
         * POST de categorías a través de API, no es necesario ya que no estaba en los requisitos de la prueba.
         */

//        $category = new Category();
//        $category->setName('Calefactor');
//        $category->setDescription('Calefactor descripción');
//        $category->setStatus((new Status())->setId(1));
//        $category->setCreatedAt(new \DateTime());
//
//        $em->persist($category);
//
//        $em->flush();
//
//        $response = new JsonResponse();
//        $response->setData([
//            'success' => true,
//            'data' => [
//                'id' => $category->getId(),
//                'title' => $category->getName()
//            ]
//        ]);

        return $response;
    }
}
