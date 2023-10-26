<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\BookType;
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/AfficheBook')]
    function Affiche(BookRepository $repo){
        $books=$repo->findAll();
        return $this->render('book/Affiche.html.twig',
        ['book'=>$books]);
    }
    #[Route('/AjoutBook')]
    function Ajout(Request $request,ManagerRegistry $manager){
        $book=new Book;
        // $book->setPublished(True);
        $form=$this->createForm(BookType::class,$book)
        ->add('Ajout',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $nb=$book->getAuthor()->getNbBooks()+1;
            $book->getAuthor()->setNbBooks($nb);
            $em=$manager->getManager();
            $em->persist($book);
            $em->flush();
        }
        return $this->renderForm('book/Ajout.html.twig',
    ['f'=>$form]);
    }
    #[Route('/UpdateBook/{pk}',name:'Update')]
    function Update($pk,Request $request,ManagerRegistry $manager,BookRepository $repo){
        $book=$repo->find($pk);
        // $book->setPublished(True);
        $form=$this->createForm(BookType::class,$book)
        ->add('published')
        ->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$manager->getManager();
            $em->flush();
        }
        return $this->renderForm('book/Ajout.html.twig',
    ['f'=>$form]);
    }
    // function ChangeState(){
    //     $book=$repo->find($pk);
    //     if($book->getPublished()==True){
    //         $book->setPublished(False);
    //     }
    //     else{  $book->setPublished(True);}
    // }
    #[Route('/search',name:'Search')]
    function SearchBook(Request $request,BookRepository $repo){
        $ref=$request->get('r');
        $books=$repo->findBookByRef($ref);
        return $this->render('book/Affiche.html.twig',
        ['book'=>$books]);
    }
    #
    #[Route('/ShowBooks')]
    function ShowBooks(BookRepository $repo){
         $books=$repo->ShowByDateNbBooks();
        // $books=$repo->findByDateDQL();
        return $this->render('book/Affiche.html.twig',
        ['book'=>$books]);

    }
}
