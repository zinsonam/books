<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/subscribers", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        try{
            if(!$this->getUser()) throw new AccessDeniedException();
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        }
        catch(Exception $e){
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/admin/subscribers/create", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        try{
            if(!$this->getUser()) throw new AccessDeniedException();
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();

                // ATTENTION
                // Encoder les mots de passe
                // avant de les enregister dans la base
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('user_index');
            }

            return $this->render('user/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
        catch(Exception $e){
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/admin/subscribers/show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        try {
            if (!$this->getUser()) throw new AccessDeniedException();
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);
        }
        catch(Exception $e){
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/admin/subscribers/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        try {
            if(!$this->getUser()) throw new AccessDeniedException();
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user_index');
            }

            return $this->render('user/edit.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
        catch(Exception $e){
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/admin/subscribers/delete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        try {
            if(!$this->getUser()) throw new AccessDeniedException();
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }

            return $this->redirectToRoute('user_index');
        }
        catch(Exception $e){
            return $this->redirectToRoute('home');
        }
    }


}
