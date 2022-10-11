<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/users/list/database", name="app_users_list_database")
     */
    public function list(
        UserRepository $userRepository
    ): Response
    {
        $users = $userRepository->findAll();

        return $this->render('user/list-database.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/users/list/reqresin", name="app_users_list_reqresin")
     */
    public function index(): Response
    {
        return $this->render('user/list-reqresin.html.twig', []);
    }
}
