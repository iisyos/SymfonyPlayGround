<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Todo;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\TodoRepository;

class HogeController extends AbstractController
{
    #[Route('/', name: 'app_hoge')]
    public function index(ManagerRegistry $doctrine, TodoRepository $todoRepo): Response
    {

        return $this->render('hoge/index.html.twig', [
            'controller_name' => 'HogeController', 'repo' => $todoRepo->findAll()
        ]);
    }
    #[Route('/create', name: 'create_task', methods: "POST")]
    public function create(Request $req, ManagerRegistry $doctrine)
    {
        $title = $req->request->get('title');
        $em = $doctrine->getManager();
        $Todo = new Todo();
        $Todo->setText($title);

        $em->persist($Todo);
        $em->flush();

        return $this->redirectToRoute('app_hoge');
    }

    #[Route('/switch/{id}', name: 'switch')]
    public function switch(int $id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $todo = $em->getRepository(Todo::class)->find($id);
        $todo->setCompleted(!$todo->getCompleted());
        $em->flush();
        return $this->redirectToRoute('app_hoge');
    }
}
