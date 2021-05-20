<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\EmpruntRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpruntController extends AbstractController
{

    /**
    * @Route("/compte/emprunt", name="emprunt_user", methods={"GET"})
    */
    public function getEmprunt(EmpruntRepository $empruntRepo, BookRepository $bookRepo){
        $user = $this->getUser(); //recupere user connecté
        //$idUser= htmlspecialchars($req->get('user_id'));
        //  to get the id of the user, instead if session with request we user user entity direct and it recognises the id of the user
        // and then the follwing code can be used to link with the books borrowed. 
        $getEmprunt = $empruntRepo->findAll(['user_id' => $user->getId()]);
        //  start with a variable table is empty and do loop to display all books whichver borrowed
        // get emprunt has all the user id of table emprunt which has all the information
        // and the loop starts with a table consisting of all the elements needed to display now go to view and start it.
        $emprunts = [];

        foreach($getEmprunt as $emprunt){
            $emprunts[$emprunt->getId()] = [
                'user_id' => $emprunt->getUserId(),
                'date_emprunt' => $emprunt->getDateEmprunt(),
                'date_rendu' => $emprunt->getDateRendu(),
                'book' => $bookRepo->findOneBy(['id' => $emprunt->getBookId()])
            ];
        }
        // we needed bookRepo to find the id for the book and display in loop. data can be table with key and value or just a variable
        // return $this->json(['emprunts' => $emprunts], 200, [], ['groups'=>'book_get']);
        return $this->render("emprunt/index.html.twig",[
            "emprunts" => $emprunts
        ]);
    }
}
