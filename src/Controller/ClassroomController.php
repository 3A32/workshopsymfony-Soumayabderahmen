<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {

        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/classrooms', name: 'list_classroom')]
    public function ListClassroom(ClassroomRepository $classroomRepository)
    {
        $classrooms = $classroomRepository->findAll();
        return $this->render("classroom/listClassroom.html.twig", array("tabClassrooms" => $classrooms));
    }
    #[Route('/addClassroom', name: 'app_addClassroom')]
    public function addClassroom(ManagerRegistry $doctrine,Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        //$classroom->setName("3B26");
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('list_classroom');
        }
        return $this->renderForm(
            "classroom/addClassroom.html.twig",
            array("formClassroom" => $form)
        );
    }
    #[Route('/updateClassroom/{id}', name: 'app_updateClassroom')]
    public function updateClassroom(ClassroomRepository $repository, $id, ManagerRegistry $doctrine, Request $request)
    {
        $classroom = $repository->find($id);
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("list_classroom");
        }
        return $this->renderForm(
            "classroom/updateClassroom.html.twig",
            array("formClassroom" => $form)
        );
    }

    #[Route('/removeClassroom/{id}', name: 'app_removeClassroom')]

    public function deleteClassroom(ManagerRegistry $doctrine, $id, ClassroomRepository $repository)
    {
        $classroom = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute("classroom");
    }
}
