<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\VoyageOrgRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VoyageOrgRepository $orgRepository ,ImageRepository $imageRepository): Response
    {
        $voyage = $orgRepository->findAll();
        $img = $imageRepository->DIST();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'voyages' => $voyage,
            'images' => $img
        ]);
    }
    /**
     * @Route("/all_voyage" , name="voy_org")
     */
    public function affiche(VoyageOrgRepository $orgRepository ,ImageRepository $imageRepository)
    {
        $voyage = $orgRepository->findAll();
        $img = $imageRepository->findAll();
        return $this->render('home/All_Voyage.html.twig',[
            'controller_name'=>'HomeController' ,
            'voyages' => $voyage,
             'images'=> $img
        ]);
    }
    /**
     * @Route("/login" , name="client_login")
     */
    public function log ()
    {
        return $this->render('home/Login_Client.html.twig',[
                        'controller_name'=>'HomeController'
    ]);
    }
    /**
     * @Route("/auth" , name="client")
     */
    public function auth ()
    {
        return $this->render('home/Chose.html.twig',[
            'controller_name'=>'HomeController'
        ]);
    }
}
