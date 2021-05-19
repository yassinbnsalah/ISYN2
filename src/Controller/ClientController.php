<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commentaire;
use App\Entity\Reservation;
use App\Form\ClientType;
use App\Form\RegistrationType;
use App\Repository\AdminRepository;
use App\Repository\AvionVoyageRepository;
use App\Repository\ClientRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ImageRepository;
use App\Repository\ReservationRepository;
use App\Repository\VoyageOrgRepository;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/admin/client", name="admin_client")
     */
    public function index(ClientRepository $clientRepository,AdminRepository $adminRepository): Response
    {    $admin =  $admin = $adminRepository->findOneBy([
        'Connecter'=>1
    ]);
        $client = $clientRepository->findAll();
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $client,
            'admin' => $admin
        ]);
    }
    /**
     * @Route("/admin/Client/ajouter" , name="ajouter_client")
     */
    public function ajouter(Request $request , EntityManagerInterface $manager,AdminRepository $adminRepository)
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $client = new Client();
        $form = $this->createForm(ClientType::class , $client);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($client);
            $manager->flush() ;
            return $this->redirectToRoute('client');
        }
        return $this->render('client/Ajouter_Client.html.twig', [
            'controller_name' => 'ClientController',
            'form' => $form->createView(),
            'admin'=> $admin
        ]);
    }
    /**
     * @Route("/admin/client/supprimer/{id}" , name="delete_client")
     */
    public function delete_C ($id, EntityManagerInterface $manager,ClientRepository $clientRepository)
    {
        $client = $clientRepository->find($id) ;
        $manager->remove($client);
        $manager->flush();
        return $this->redirectToRoute("client");
    }
    /**
     * @Route("/client/home" , name="home_client")
     */
    public function home(request $request, ClientRepository $clientRepository, EntityManagerInterface $manager,VoyageOrgRepository $orgRepository , ImageRepository $imageRepository)
    {
        $client = $clientRepository->findOneBy([
            'Connect' => 1
        ]);
        $voyage = $orgRepository->findAll();
        $img = $imageRepository->DIST();
        return $this->render('client/Home_c.html.twig',[
            'controller_name' => 'ClientController',
            'client' => $client,
            'voyages' => $voyage,
            'images' => $img
        ]);
    }
    /**
     * @Route("/client/login" , name="login_client")
     */
    public function loginn(request $request, ClientRepository $clientRepository, EntityManagerInterface $manager)
    {
        $message = NULL ;

       $clients = $clientRepository->findAll();
       foreach ($clients as $client){
           $client->getConnect(False);
           $manager->persist($client);
           $manager->flush();
       }
       if($request->request->count()>0){
           $client = $clientRepository->findOneBy([
               'mail' => $request->request->get('mail'),
               'password' => $request->request->get('password')
           ]);
           if($client != NULL ){
               $client->setConnect(True);
               $manager->persist($client);
               $manager->flush();
               return $this->redirectToRoute("home_client");
           }
           else{
               $message = "mail or password incorrect ";
           }
       }
       return $this->render('home/Login_Client.html.twig',[
           'controller_name' => 'ClientController',
           'message' => $message
       ]);
    }
    /**
     * @Route("/logout" , name="client_logout")
     */
    public function logout(ClientRepository $clientRepository, EntityManagerInterface $manager)
    {
        $clients = $clientRepository->findAll();
        foreach ($clients as $client){
            $client->setConnect(False);
            $manager->persist($client);
            $manager->flush();
        }
        return $this->redirectToRoute("client");
    }
    /**
     * @Route("client/voy/detail/{id}" , name="details_voy_org")
     */
    public function detail($id, Request $request , EntityManagerInterface $manager, CommentaireRepository $commentaireRepository , VoyageOrgRepository $orgRepository, ClientRepository $clientRepository, AvionVoyageRepository $avionVoyageRepository , ImageRepository $imageRepository){
        $voy = $orgRepository->findOneBy([
           'id'=> $id
        ]);
        $client = $clientRepository->findOneBy([
            'Connect' => 1
        ]);

        if($request->request->count()>0){
            $commentaire = new Commentaire() ;
            $commentaire->setCl($client)
                        ->setVoy($voy->getVoy())
                        ->setContenu($request->request->get('conetnu'));
            $manager->persist($commentaire);
            $manager->flush();

        }
        $Avs = $avionVoyageRepository->findAll();
        $img = $imageRepository->findAll();
        $cmnt = $commentaireRepository->findAll();
        return $this->render('client/Details_org.html.twig',[
            'controller_name' => 'ClientController' ,
            'voyage' => $voy ,
            'client' => $client,
            'Avs' => $Avs ,
            'images' => $img,
            'commentaires' => $cmnt
        ]);
    }
    /**
     * @Route("/client/reservation/{id}" , name="reservation_org")
     */
    public function reservation1($id, ClientRepository $clientRepository, Request $request , VoyageRepository $voyageRepository, EntityManagerInterface $manager, AvionVoyageRepository $avionVoyageRepository , ImageRepository $imageRepository)
    {
        $client = $clientRepository->findOneBy([
            'Connect' => 1
        ]);
        $voy = $voyageRepository->findOneBy([
            'id'=> $id
        ]);
        if($request->request->count()>0)
        {
            $res = new Reservation();
            $res->setNbPers($request->request->get('nb_perso'))
                ->setDateRes(new \DateTime('now'))
                ->setConfirmer(False)
                ->setVoy($voy)
                ->setCl($client);
            $manager->persist($res);
            $manager->flush();
            return $this->redirectToRoute('home_client');
        }

        $client = $clientRepository->findOneBy([
            'Connect' => 1
        ]);

        $img = $imageRepository->findAll();
        return $this->render('reservation/Res_client.html.twig',[
            'controller_name' => 'ClientController' ,
            'client' => $client,
            'images' => $img
        ]);
    }
    /**
     * @Route("/client/reservation" , name="res_client")
     */
    public function liste(ClientRepository $clientRepository, Request $request , VoyageRepository $voyageRepository, EntityManagerInterface $manager , ReservationRepository $reservationRepository)
    {
        $client = $clientRepository->findOneBy([
            'Connect' => 1
        ]);
        $res = $reservationRepository->findAll();
        return $this->render('reservation/Liste_reservation.html.twig',[
            'controller_name' => 'ClientController',
            'client' => $client ,
            'reservations' => $res
        ]);
    }
    /**
     * @Route ("/client/detail/reservation/{id}" , name="detail_reservation_client")
     */
    public function det($id ,ClientRepository $clientRepository, VoyageRepository $voyageRepository, ReservationRepository $reservationRepository)
    {
        $client = $clientRepository->findOneBy([
            'Connect' => 1
        ]);
        $res = $reservationRepository->findOneBy([
            'id' => $id
        ]); 
        return $this->render('reservation/Details_res.html.twig',[
            'controller_name' => 'ClientController', 
            'client' => $client , 
            'reservation' => $res
        ]) ;
    }
    /**
     * @Route("/client/reserver/ticket" , name="reserver_ticket")
     */
    public function search(ClientRepository $clientRepository, Request $request , VoyageRepository $voyageRepository, EntityManagerInterface $manager , ReservationRepository $reservationRepository)
    {
        $client = $clientRepository->findOneBy([
            'Connect' => 1
        ]);
        if($request->request->count()>0){
            //$date_aller =  new \DateTime($request->request->get('date_aller')) ;
            $voy = $voyageRepository->findBy(
                ['from_Ville' => $request->request->get('form'),
                'to_Ville' => $request->request->get('to'),
                'date_aller' => new \DateTime($request->request->get('date_depart')),
                'date_retour' => new \DateTime($request->request->get('date_retour'))]);
            //$voy = $voyageRepository->findAll();
            return $this->render('voyage/Liste_Voyage.html.twig' ,[
                'controller_name' => 'ClientController',
                'voyages' => $voy ,
                'client' => $client
            ]);
        }
        return $this->render('voyage/Reserve_ticket.html.twig' ,[
            'controller_name' => 'ClientController',
            'client' => $client
        ]);

    }
}
