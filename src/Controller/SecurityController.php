<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin/new" ,name="new admin" )
     */
    public function registration(Request$request , EntityManagerInterface $manager){
        $admin = new Admin() ;

        $form = $this->createForm(RegistrationType::class, $admin);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($admin);
            $manager->flush() ;
            return $this->redirectToRoute('admin');
        }
        return $this->render('security/Registration.html.twig',[
            'controller_name' => 'SecurityController',
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin", name="security_login")
     */
    public function login(Request $request)
    {

        //return $this->redirectToRoute('home_admin');
        return $this->render('security/login.html.twig');
    }
}
