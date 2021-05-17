<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\RegistrationType;
use App\Repository\AdminRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/admin/client", name="client")
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
    public function delete_C ($id, request $request, EntityManagerInterface $manager,ClientRepository $clientRepository)
    {
        $client = $clientRepository->find($id) ;
        $manager->remove($client);
        $manager->flush();
        return $this->redirectToRoute("client");
    }
}
