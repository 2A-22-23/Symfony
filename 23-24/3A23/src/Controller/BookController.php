<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/AjoutBook')]
    function AjoutBook(Request $req, ManagerRegistry $manager){
        $book=new Book;
        $form=$this->createForm(BookType::class,$book)
        ->add('Ajout',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em=$manager->getManager();
            $em->persist($book);
            $em->flush();
            return new Response('Ajout avec succés!!');
        }
        return $this->renderForm('book/Ajout.html.twig',
                ['ff'=>$form]);
    }
    #[Route('/AfficheBook')]
    function AfficheBook(BookRepository $repo){
        $books=$repo->findAll();
        return $this->render('book/Affiche.html.twig',
        ['bb'=>$books]);

    }
}
