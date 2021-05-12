<?php

namespace App\Controller;

use App\Entity\Avion;
use App\Form\AvionType;
use App\Repository\AvionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvionController extends AbstractController
{
    /**
     * @Route("/avion", name="avion")
     */
    public function index(AvionRepository $avionRepository): Response
    {
        $avion = $avionRepository->findAll();
        return $this->render('avion/index.html.twig', [
            'controller_name' => 'AvionController',
            'avions' => $avion
        ]);
    }
    /**
     * @Route ("/avion/new" , name="new avion" )
     */
    public function ajouter(Request $request , EntityManagerInterface $manager)
    {
        $avion = new Avion();
        $form = $this->createForm(AvionType::class,$avion) ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($avion);
            $manager->flush();
            return $this->redirectToRoute("avion");
        }
        return $this->render('avion/ajouter_avion.html.twig' ,[
            'controller_name' => 'AvionController',
            'form' => $form->createView()
        ]);

    }
    /**
     * @Route ("/avion/supprimer/{id}" , name="delete_avion")
     */
    public function delete_A($id ,AvionRepository $avionRepository, EntityManagerInterface $manager)
    {
        $avion = $avionRepository->find($id);
        $manager->remove($avion);
        $manager->flush();
        return $this->redirectToRoute("avion");
    }
    /**
     * @Route ("/avion/modifier/{id}" , name="update_avion")
     */
    public function update_A($id , AvionRepository $avionRepository ,Request $request , EntityManagerInterface $manager)
    {
        $avion = $avionRepository->find($id);
        $form = $this->createForm(AvionType::class,$avion) ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($avion);
            $manager->flush();
            return $this->redirectToRoute("avion");
        }
        return $this->render('avion/modifier_avion.html.twig' ,[
            'controller_name' => 'AvionController',
            'form' => $form->createView()
        ]);
    }
}
