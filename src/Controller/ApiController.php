<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/books", name="api", methods={"GET"})
     */
    public function index(BookRepository $bookRepo): Response
    {
        return $this->json($bookRepo->findAll(), 200, [], ['groups'=>'book_get']);
    }

    /**
     * @Route("/api/category/{nom}", name="api_category", methods={"GET"})
     */
    public function getCategory(Request $req, CategoryRepository $catRepo)
    {
        $nom = htmlspecialchars($req->get('nom'));

        $getCat = $catRepo->findOneBy(['name' => $nom]);

        $books = $getCat ? $getCat->getBooks() : [];
        
        return $this->json(['nom' => $nom, 'books' => $books], 200, [], ['groups'=>'book_get']);
    }

}
