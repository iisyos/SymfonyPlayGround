<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $req, UserRepository $userRepo, SessionInterface $session): Response
    {
        return $this->render('user/index.html.twig', [
            'repo' => $userRepo->findAll(),
            'currentName' => $session->get('name')
        ]);
    }
    #[Route('/user/create', name: 'app_user_create')]
    public function create(Request $req, ManagerRegistry $doctrine, UserRepository $userRepo): Response
    {
        $name = $req->request->get('title');
        $age = $req->request->get('age');
        $gender = $req->request->get('gender');

        if ($gender === null) {
            $this->addFlash('name', $name);
            $a = $this->generateUrl('app_user');
            return $this->redirect($a);
        }

        $em = $doctrine->getManager();
        $User = new User();
        $User->setname($name)->setage($age)->setGender($gender);
        $em->persist($User);
        $em->flush();

        return $this->redirectToRoute('app_user');
    }
}
