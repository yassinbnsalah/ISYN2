<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/home", name="home_admin")
     */
    public function index(AdminRepository $adminRepository): Response
    {
        $admin = $adminRepository->findOneBy([
            'Connecter' => 1
        ]) ;
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'admin' => $admin
        ]);
    }
    /**
     * @Route("/admin", name="admin_login")
     */
    public function login(Request $request, AdminRepository $adminRepository, EntityManagerInterface $manager)
    { $message = NULL ;
        $admins = $adminRepository->findAll();
        foreach ($admins as $admin) {
            $admin->setConnecter(False);
            $manager->persist($admin);
            $manager->flush();
        }
        if($request->request->count()>0)
        {
            $admin = $adminRepository->findOneBy([
                'Email'=>$request->request->get('mail'),
                'password' => $request->request->get('password')
            ]);
            if($admin != NULL){
                $admin->setConnecter(True) ;
                $manager->persist($admin);
                $manager->flush();
                return $this->render('admin/index.html.twig', [
                    'controller_name' => 'AdminController',
                    'admin'=>$admin
                ]);
            }
            else{
                $message = "mail or password incorrect ";
            }
        }
        //return $this->redirectToRoute('home_admin');
        return $this->render('security/login.html.twig' ,[
            'controller_name' => 'AdminController',
            'message'=> $message
        ]);
    }
}
