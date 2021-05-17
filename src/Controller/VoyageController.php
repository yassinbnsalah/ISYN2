<?php

namespace App\Controller;

use App\Entity\AvionVoyage;
use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\AdminRepository;
use App\Repository\AeroportRepository;
use App\Repository\AvionRepository;
use App\Repository\AvionVoyageRepository;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoyageController extends AbstractController
{
    /**
     * @Route("/admin/voyage", name="voyage")
     */
    public function index(VoyageRepository $voyageRepository , AvionVoyageRepository $avionVoyageRepository , AdminRepository $adminRepository): Response
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        $voyage = $voyageRepository->findAll();
        $av = $avionVoyageRepository->findAll();
        return $this->render('voyage/index.html.twig', [
            'controller_name' => 'VoyageController',
            'voyages' => $voyage,
            'Avs' => $av,
            'admin' => $admin
        ]);
    }
    /**
     * @Route ("/admin/voyage/new" , name="new voyage")
     */
    public function add (Request $request ,AeroportRepository $aeroportRepository , EntityManagerInterface $manager , AvionRepository $avionRepository, AdminRepository $adminRepository)
    {
        $admin =  $admin = $adminRepository->findOneBy([
            'Connecter'=>1
        ]);
        if($request->request->count()>0)
        {
            $dep_ae = $aeroportRepository->findOneBy([
                'nom' => $request->request->get('aero_aller')
            ]);
            $all_ae = $aeroportRepository->findOneBy([
                'nom' => $request->request->get('aero_retour')
            ]);
            $esc_ae = $aeroportRepository->findOneBy([
                'nom' => $request->request->get('aero_esca')
            ]);
            if($request->request->get('date_retour') == NULL){
                $date_retour = NULL ;
            }
            else{
                $date_retour = new \DateTime($request->request->get('date_retour')) ;
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
                'nom'=> $request->request->get('avion_retour')
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
            return $this->redirectToRoute("voyage");
        }
        return $this->render('voyage/ajouter_voyage.html.twig', [
            'controller_name' => 'VoyageController',
            'admin' => $admin
        ]);
    }

    /**
     * @Route("/voyage/delete/{id}" , name="delete_voyage")
     */
    public function delete($id , VoyageRepository $voyageRepository , AvionVoyageRepository $avionVoyageRepository, EntityManagerInterface $manager)
    {
        $voyage = $voyageRepository->find($id);
        $avs = $avionVoyageRepository->findAll();
        foreach ($avs as $av)
        {
           if($av->getVoy() == $voyage)
           {
               $manager->remove($av);
               $manager->flush();
           }
        }
        $manager->remove($voyage);
        $manager->flush();
        return $this->redirectToRoute("voyage");
    }
    /**
     * @Route("/admin/voyage/detail/{id}" , name="detail_voyage")
     */
    public function details($id , VoyageRepository $voyageRepository , AvionVoyageRepository $avionVoyageRepository, AdminRepository $adminRepository)
    {

        $admin =  $admin = $adminRepository->findOneBy([
        'Connecter'=>1
    ]);
        $voyage = $voyageRepository->find($id);
        $Avs = $avionVoyageRepository->findAll();

        return $this->render('voyage/Details_Voyage.html.twig',
        [
            'controller_name'=>'VoyageController',
            'voyage' =>$voyage,
            'Avs'=>$Avs,
            'admin' => $admin
        ]) ;
    }
}
