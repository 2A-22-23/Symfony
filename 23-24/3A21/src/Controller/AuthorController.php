<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Author;
use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class AuthorController extends AbstractController
{
    private $authors = array(
        array('id' => 1, 'picture' => '/images/ESPRIT.jpg',
            'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ',
            'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/ESPRIT.jpg',
            'username' => ' William Shakespeare',
            'email' => ' william.shakespeare@gmail.com', 'nb_books' => 200),
        array('id' => 3, 'picture' => '/images/ESPRIT.jpg',
            'username' => 'Taha Hussein',
            'email' => 'taha.hussein@gmail.com', 'nb_books' => 300));
    
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/list')]
    public function list()
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/ESPRIT.jpg',
                'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ',
                'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/ESPRIT.jpg',
                'username' => ' William Shakespeare',
                'email' => ' william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/ESPRIT.jpg',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com', 'nb_books' => 300));
        
        return $this->render('author/list.html.twig',
            ['auth' => $authors]);
    }
    #[Route('/details/{id}',name:'dd')]
    function authorDetails($id){
        return $this->render('author/details.html.twig',
        ['i'=>$id,'a'=>$this->authors]);

    }
    #[Route('/AfficheAuthor',name:'Aff')]
    function AfficheAuthor(AuthorRepository $repo){
        $auth=$repo->findAll();
        return $this->render('author/Affiche.html.twig',
        ['aa'=>$auth]);

    }
    #[Route('/DetailAuthor/{ii}',name:'Detail_Author')]
    function DetailAuthor(AuthorRepository $repo,$ii){
            $auth=$repo->find($ii);
            return $this->render(
            'author/Detail_Author.html.twig',
            ['aa'=>$auth]);
    }
    #[Route('/DeleteAuthor/{id}',name:'Delete')]
    function DeleteAuthor(ManagerRegistry $manager,AuthorRepository $repo,$id){
        #récuperer l'id de l'obj à supprimler
        $auth=$repo->find($id);
        #Supp
        $em=$manager->getManager();
        $em->remove($auth);
        $em->flush();
        #Retourner l'affiche via name route
        return $this->redirectToRoute('Aff');
    }#[Route('/AjoutAuthor')]
    function AjoutAuthor(ManagerRegistry $manager){
        #objectInstance
        $author=new Author();
        $author->setUsername('Ahmed');
        $author->setEmail('a.h@esprit.tn');
        $em=$manager->getManager();
        $em->persist($author);
        $em->flush();
        #Resultat
        #1
        
        return $this->redirectToRoute('Aff');
        #2
        // return new Response('<i>Add success!');
    }
    #[Route('/Ajout')]
    function Ajout(ManagerRegistry $manager,Request $request){
        $author=new Author();
        $form=$this->createForm(AuthorType::class,$author)
        ->add('Ajout',SubmitType::class);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) { 
            $em=$manager->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('Aff');
        }
        return $this->renderForm('author/AjoutAuthor.html.twig',['ff'=>$form]);
            
    }
    #[Route('/Update/{id}',name:'U')]
    function Update($id,ManagerRegistry $manager,Request $request,AuthorRepository $repo){
        $author=$repo->find(($id));
        $form=$this->createForm(AuthorType::class,$author)
        ->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) { 
            $em=$manager->getManager();
            // $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('Aff');
        }
        return $this->renderForm('author/AjoutAuthor.html.twig',['ff'=>$form]);
            
    }
}
