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
            // $book->setPublished(True);
            $em->persist($book);
            $em->flush();
            return new Response('Ajout avec succés!!');
        }
        return $this->renderForm('book/Ajout.html.twig',
                ['ff'=>$form]);
    }
    #[Route('/AfficheBook',name:"Aff")]
    function AfficheBook(BookRepository $repo){
        $books=$repo->findAll();
        return $this->render('book/Affiche.html.twig',
        ['bb'=>$books]);

    }
    #[Route('/UpdateBook/{id}',name:'Update')]
    function UpdateBook($id,Request $req, ManagerRegistry $manager,BookRepository $repo){
        // $book=new Book;
        $book=$repo->find($id);
        $form=$this->createForm(BookType::class,$book)
        ->add('Update',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $em=$manager->getManager();
            $em->flush();
            return $this->redirectToRoute("Aff");
        }
        return $this->renderForm('book/Ajout.html.twig',
                ['ff'=>$form]);
    }
    #[Route("/Delete/{id}", name:"Delete")]
    function Delete($id,ManagerRegistry $manager,BookRepository $repo){
        $book=$repo->find($id);
        $em=$manager->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute("Aff");
    }
    #[Route('/search',name:'Search')]
    function SearchBook(Request $request,BookRepository $repo){
        // $ref=$_POST['r']
        $ref=$request->get('r');
        $books=$repo->SearchByRef($ref);
        return $this->render('book/Affiche.html.twig',
        ['bb'=>$books]);
    }
    #[Route('/findBook')]
    function findBook(Request $request,BookRepository $repo){
        // $books=$repo->findBook();
        $books=$repo->findByDate();
        return $this->render('book/Affiche.html.twig',
        ['bb'=>$books]);
    }
}
