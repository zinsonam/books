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
     * @Route("/api", name="api", methods={"GET"})
     */
    public function index(BookRepository $bookRepo): Response
    {
        return $this->json($bookRepo->findAll(), 200, [], ['groups'=>'book_get']);
    }

    // /**
    //  * @Route("/api/category/new", name="api_new_category", methods={"POST"})
    //  */
    // public function addCategory(Request $req, SerializerInterface $serializer, EntityManagerInterface $manager, ValidatorInterface $validator) : Response {
    //     $data = $req->getContent();
        
    //     $cat = $serializer->deserialize($data, category::class, 'json');

    //     $manager->persist($cat);
    //     $manager->flush();

    //     return $this->json($cat, 201, [], ['groups'=>'book_get']);
    // }

    /**
     * @Route("/api/category/{nom}", name="api_category", methods={"GET"})
     */
    public function getCategory(Request $req, CategoryRepository $catRepo, SerializerInterface $serializer)
    {
        // $data = $req->getContent();
        // $cat = $book->getCategory();
        $nom = htmlspecialchars($req->get('nom'));
        // $cat= $serializer->deserialize($nom, Book::class, 'json');
        // $book = $catRepo->findOneBy(['nom'=>$cat->getName()]);
        // $cat->setCategory($book);

        $getCat = $catRepo->findOneBy(['name' => $nom]);
        
        
        return $this->json(['nom' => $nom, 'books' => $getCat->getBooks()], 200, [], ['groups'=>'book_get']);
        //$cat->getBooks();
    }

    // /**
    //  * @Route("/api/book/new", name"api_new_book", methods={"POST"})
    //  */
    // public function addBook(Request $req, CategoryRepository $catRepo, SerializerInterface $serializer, EntityManagerInterface $manager){
    //     $data = $req->getContent();

    //     $book = $serializer->deserialize($data, Book::class, 'json');

    //     $cat = $book->getCategory();
    //     $getCat = $catRepo->findOneBy(['name'=>$cat->getName()]);

    //     $book->setCategory($getCat);

    //     $manager->persist($book);
    //     $manager->flush();

    //     return $this->json($book, 201, [], ['groups'=>'book_get']);
    // }
}
