<?php

namespace App\Controller;

use App\Entity\Aeroport;
use App\Form\AeroportType;
use App\Repository\AdminRepository;
use App\Repository\AeroportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AeroportController extends AbstractController
{
    public function Admin_Connect( AdminRepository $adminRepository)
    {
        $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        return $admin;
    }
    /**
     * @Route("/admin/aeroport", name="aeroport")
     */
    public function index(AeroportRepository $aeroportRepository, AdminRepository $adminRepository): Response
    {
        $admin = $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        if($admin == NULL){
            return $this->render('security/login.html.twig' ,[
                'controller_name' => 'AdminController',
                'message'=> NULL
            ]);
        }
        $aeroport = $aeroportRepository->findAll();
        return $this->render('aeroport/index.html.twig', [
            'controller_name' => 'AeroportController',
            'aeroports' => $aeroport,
            'admin' => $admin
        ]);
    }
    /**
     * @Route ("/admin/aeroport/new" , name="new_aeroport")
     */
    public function ajouter_A( Request $request , EntityManagerInterface $manager,AdminRepository $adminRepository)
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        if($admin == NULL){
            return $this->render('security/login.html.twig' ,[
                'controller_name' => 'AdminController',
                'message'=> NULL
            ]);
        }
        $aeroport = new Aeroport() ;
        $form = $this->createForm(AeroportType::class,$aeroport) ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($aeroport);
            $manager->flush();
            return $this->redirectToRoute("aeroport");
        }
        return $this->render('aeroport/ajouter_aeroport.html.twig',[
            'controller_name'=> 'AeroportController',
            'form' => $form->createView(),
            'admin' => $admin
        ]) ;
    }
    /**
     * @Route ("/admin/aeroport/delete/{id}" , name="delete_aeroport")
     */
    public function delete_ae($id ,AeroportRepository $aeroportRepository, EntityManagerInterface $manager, AdminRepository $adminRepository)
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $aeroport = $aeroportRepository->find($id);
        $manager->remove($aeroport);
        $manager->flush();
        return $this->redirectToRoute("aeroport");
    }
    /**
     * @Route("/admin/aeroport/modify/{id}" , name="update_aeroport")
     */
    public function modify_ae($id ,Request $request , EntityManagerInterface $manager,AeroportRepository $aeroportRepository ,AdminRepository $adminRepository)
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $aeroport = $aeroportRepository->find($id) ;
        $form = $this->createForm(AeroportType::class,$aeroport) ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($aeroport);
            $manager->flush();
            return $this->redirectToRoute("aeroport");
        }
        return $this->render('aeroport/ajouter_aeroport.html.twig',[
            'controller_name'=> 'AeroportController',
            'form' => $form->createView(),
            'admin' => $admin
        ]) ;

    }
}
