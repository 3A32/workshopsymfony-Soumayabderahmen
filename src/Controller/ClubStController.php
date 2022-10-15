<?php

namespace App\Controller;
use App\Entity\ClubSt;
use App\Form\ClubStType;
use App\Repository\ClubStRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ClubStController extends AbstractController
{
    #[Route('/clubst', name: 'app_clubst')]
    public function index(): Response
    {
        return $this->render('clubst/index.html.twig', [
            'controller_name' => 'ClubStController',
        ]);
    }
  

    #[Route('/clubsts', name: 'list_clubst')]
    public function listClubSt(ClubStRepository $clubStRepository)
    {
        $clubsts = $clubStRepository->findAll();
        return $this->render('clubst/listClubst.html.twig', [
        'clubsts' => $clubsts,
        ]);

    }

    #[Route('/addClubSt', name:'addclubst')]
    public function addClubSt(ManagerRegistry $doctrine,Request $request){
      $clubst = new ClubSt();
      $form = $this->createForm(ClubStType::class,$clubst);
      $form->handleRequest($request);
      if($form->isSubmitted()){
      $em = $doctrine->getManager();
      $em->persist($clubst);
      $em->flush();
      return $this->redirectToRoute("list_clubst");
     
    }
    return $this->renderForm("clubst/addClubst.html.twig",
            array("formClubst"=>$form));}

            
#[Route('/updateClubSt/{ref}', name:'updateClubSt')]
public function updateClubSt(ManagerRegistry $doctrine,Request $request,$ref,ClubStRepository $clubStRepository){
  
    $clubSt=$clubStRepository->find($ref);
    $form=$this->createForm(ClubStType::class,$clubSt);
    $form->handleRequest($request);
    if ($form->isSubmitted()){
        $em=$doctrine->getManager();
        $em->persist($clubSt);
        $em->flush();
        return $this->redirectToRoute("list_clubst");
    }
    return $this->renderForm("clubst/updateClubst.html.twig",
            array("formClubst"=>$form));
        
        }
        #[Route('/removeClubSt/{ref}', name: 'app_removeClubSt')]

        public function deleteClubSt(ManagerRegistry $doctrine,$ref,ClubStRepository $clubStRepository)
        {
            $clubSt= $clubStRepository->find($ref);
            $em= $doctrine->getManager();
            $em->remove($clubSt);
            $em->flush();
            return $this->redirectToRoute("list_clubst");
    
        }

}

