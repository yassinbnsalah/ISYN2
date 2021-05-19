<?php

namespace App\Controller;

use App\Repository\AdminRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClientRepository;
use App\Repository\VoyageRepository;

use Doctrine\ORM\EntityManagerInterface;
class ReservationController extends AbstractController
{
    /**
     * @Route("/admin/reservation", name="reservation")
     */
    public function index(ReservationRepository $reservationRepository,AdminRepository $adminRepository): Response
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $res = $reservationRepository->findAll();
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'res'=> $res,
            'admin'=> $admin
        ]);
    }
    /**
     * @Route("/admin/reservation/detail/{id}" , name="detail_reservations_admin")
     */
    public function det(ReservationRepository $reservationRepository,AdminRepository $adminRepository,$id)
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $res = $reservationRepository->findOneBy([
            'id' => $id
        ]); 
        return $this->render('reservation/Details_res_A.html.twig', [
            'controller_name' => 'ReservationController',
            'reservation'=> $res,
            'admin'=> $admin
        ]);
    }
     /**
     * @Route("/admin/reservation/confirmer/{id}" , name="confimer_res")
     */
    public function confirmer($id, EntityManagerInterface $manager,ReservationRepository $reservationRepository,AdminRepository $adminRepository)
    {
        $res = $reservationRepository->findOneBy([
            'id' => $id
        ]); 
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $res->setConfirmer(TRUE); 
        $manager->persist($res); 
        $manager->flush(); 
        return $this->render('reservation/Details_res_A.html.twig', [
            'controller_name' => 'ReservationController',
            'reservation'=> $res,
            'admin'=> $admin
        ]);
    }


}
