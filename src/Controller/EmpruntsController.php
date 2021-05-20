<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Form\EmpruntEmailType;
use App\Repository\EmpruntRepository;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmpruntsController extends AbstractController
{

    /**
     * @Route("/admin/emprunts/new", name="emprunts_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emprunt);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('emprunts/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/admin/emprunts/list/{id}", name="emprunts_listuser", methods={"GET","POST"})
     */
    public function showForAUser(User $user, EmpruntRepository $repoEmprunts, BookRepository $bookRepo): Response
    {
        $result = $repoEmprunts->findBy(['user_id' => $user->getId()]);

        $emprunts = [];

        foreach($result as $emprunt){
            $emprunts[$emprunt->getId()] = [
                'id' => $emprunt->getId(),
                'user_id' => $emprunt->getUserId(),
                'date_emprunt' => $emprunt->getDateEmprunt(),
                'date_rendu' => $emprunt->getDateRendu(),
                'book' => $bookRepo->findOneBy(['id' => $emprunt->getBookId()])
            ];
        }

        return $this->render('emprunts/list.html.twig', [
            'emprunts' => $emprunts
        ]);

    }


    /**
     * @Route("/admin/emprunts/list/{id}/{emprunt_id}/returnBook", name="emprunts_returnBook", methods={"GET","POST"})
     */
    public function returnBook(User $user, String $emprunt_id, EmpruntRepository $repoEmprunts){
        
        $emprunt_id = htmlspecialchars($emprunt_id);
        $emprunt = $repoEmprunts->findOneBy(['id' => $emprunt_id]);

        $date = new \Datetime();
        $date = $date->format('d/m/Y \à H:i');

        $emprunt->setDateRendu($date);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('emprunts_listuser', ['id' => $user->getId()]);

    }
}
