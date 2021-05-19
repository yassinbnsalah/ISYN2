<?php

namespace App\Controller;

use App\Entity\AvionVoyage;
use App\Entity\Image;
use App\Entity\Voyage;
use App\Entity\VoyageOrg;
use App\Form\VoyageOrgType;
use App\Repository\AdminRepository;
use App\Repository\AeroportRepository;
use App\Repository\AvionRepository;
use App\Repository\AvionVoyageRepository;
use App\Repository\ImageRepository;
use App\Repository\VoyageOrgRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoyageOrgController extends AbstractController
{
    /**
     * @Route("/admin/voyage/org", name="voyage_org")
     */
    public function index(VoyageOrgRepository $orgRepository, AdminRepository $adminRepository): Response
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $voyage = $orgRepository->findAll();
        return $this->render('voyage_org/index.html.twig', [
            'controller_name' => 'VoyageOrgController',
            'voyages'=> $voyage,
            'admin'=>$admin
        ]);
    }
    /**
     * @Route ("/admin/voyage/org/ajoute" , name="ajoute_voyage_org")
     */
    public function ajouter(AdminRepository $adminRepository , Request $request ,AeroportRepository $aeroportRepository , EntityManagerInterface $manager , AvionRepository $avionRepository)
    {
        $admin = $admin = $adminRepository->findOneBy([
            'Connecter' => 1
        ]);

        /*$form = $this->createForm(VoyageOrgType::class, $voy);
        $form->handleRequest($request);*/
        if ($request->request->count() > 0) {
            $dep_ae = $aeroportRepository->findOneBy([
                'nom' => $request->request->get('aero_aller')
            ]);
            $all_ae = $aeroportRepository->findOneBy([
                'nom' => $request->request->get('aero_retour')
            ]);
            $esc_ae = $aeroportRepository->findOneBy([
                'nom' => $request->request->get('aero_esca')
            ]);
            if ($request->request->get('date_retour') == NULL) {
                $date_retour = NULL;
            } else {
                $date_retour = new \DateTime($request->request->get('date_retour'));
            }
            $voyage = new Voyage();
            $voyage->setFromVille($request->request->get('form'))
                ->setToVille($request->request->get('to'))
                ->setDateAller(new \DateTime($request->request->get('date_depart')))
                ->setDateRetour($date_retour)
                ->setArArrive($all_ae)
                ->setArDepart($dep_ae)
                ->setArEscale($esc_ae);
            $manager->persist($voyage);
            $manager->flush();
            $Av = new AvionVoyage();
            $av_dep = $avionRepository->findOneBy([
                'nom' => $request->request->get('avion_aller')
            ]);
            $av_ret = $avionRepository->findOneBy([
                'nom' => $request->request->get('avion_retour')
            ]);
            $Av = new AvionVoyage();
            $Av->setVoy($voyage)
                ->setAv($av_dep)
                ->setEtat('aller');
            $manager->persist($Av);
            $manager->flush();
            $Av = new AvionVoyage();
            $Av->setVoy($voyage)
                ->setAv($av_ret)
                ->setEtat('retour');
            $manager->persist($Av);
            $manager->flush();
            $voy = new VoyageOrg();
            $voy->setVoy($voyage)
                ->setVille($request->request->get('to'))
                ->setProgramme($request->request->get('prog'))
                ->setNbJour($request->request->get('nb_jour'));
            $manager->persist($voy);
            $manager->flush();
            //$images = $form->get('images')->getData();

            /* foreach ($images as $îmage){
                 $fichier = $this->generateUniqueFileName().'.'.$image->guessExtension();
                 try {
                 $image->move(
                     $this->getParameter('images_directory'),
                     $fichier
                 );
             } catch (FileException $e) {
                 // ... handle exception if something happens during file upload
             }*/
            $img = new Image();
            $img->setName($request->request->get('imag'))
                ->setVoyageOrg($voy);
            //$voy->addImage($img);
            $manager->persist($img);
            $manager->flush();


           return $this->redirectToRoute("voyage_org");
        }
        return $this->render('voyage_org/Ajouter_org.html.twig', [
            'controller_name' => 'VoyageOrgController',
            'admin' => $admin
        ]);
    }
    /**
     * @Route("/admin/voyage/org/detail/{id}" , name="details_voyorg")
     */
    public function details($id ,AdminRepository $adminRepository, VoyageOrgRepository $orgRepository ,AvionVoyageRepository $avionVoyageRepository , ImageRepository $imageRepository)
    {
        $admin = $admin = $adminRepository->findOneBy([
            'Connecter' => 1
        ]);
        $voy = $orgRepository->findOneBy([
            'id' => $id
        ]);

        $img = $imageRepository->findAll();
        $Avs = $avionVoyageRepository->findAll();
        return $this->render('voyage_org/Details_org.html.twig',[
            'controller_name'=> 'VoyageOrgController',
            'admin' =>$admin,
            'voyage' => $voy,
            'Avs'=>$Avs ,
            'images' => $img
        ]);
    }
    /**
     * @Route("/admin/voyage/org/ajouterimg/{id}" , name="ajouter_image")
     */
    public function aj($id, AdminRepository $adminRepository, VoyageOrgRepository $orgRepository, Request $request ,EntityManagerInterface $manager)
    {
        $admin = $admin = $adminRepository->findOneBy([
            'Connecter' => 1
        ]);
        $voy = $orgRepository->findOneBy([
            'id' => $id
        ]);
        if($request->request->count()>0){
            $image = new Image();
            $image->setName($request->request->get('imag'))
                  ->setVoyageOrg($voy) ;
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute("voyage_org");
        }
        return $this->render('voyage_org/Ajoute_image.html.twig',[
            'controller_name' => 'VoyageOrgController' ,
            'admin' => $admin
        ]);
    }
}
