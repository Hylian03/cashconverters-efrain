<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Status;
use App\Form\Type\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="app_category")
     */
    public function index(
        CategoryRepository $categoryRepository
    ): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("category/{id}/features", name="app_category_features")
     */
    public function features(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository,
                             StatusRepository $statusRepository, $id): Response
    {
        $category = $categoryRepository->find($id);

        $product = new Product();
        $formOptions = [
            'categoryId' => $category->getId()
        ];
        $form = $this->createForm(ProductType::class, $product, $formOptions);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $product->setCategory($category);
            $product->setStatus($statusRepository->find(1));
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product successfully created.');
            return $this->redirectToRoute('app_category_features', ['id' => $id]);
        }

        return $this->render('category/features.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }
}
