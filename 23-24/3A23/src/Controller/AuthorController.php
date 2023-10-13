<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Author;
#[Route('/author')]
class AuthorController extends AbstractController
{
    private $authors = array(
        array('id' => 1, 'picture' => '/images/ESPRIT.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/ESPRIT.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/ESPRIT.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/index', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', 
        [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/showAuthor/{name}')]
    function showAuthor($name){
        return $this->render(
        'author/show.html.twig',
        ['n'=>$name]);
    }
    #[Route('/list')]
    function list(){
        $authors = array(
            array('id' => 1, 'picture' => '/images/ESPRIT.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/ESPRIT.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/ESPRIT.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            return $this->render('author/list.html.twig',
            ['auth'=>$authors]);

    }
    #[Route('/Affiche',name:'Aff')]
    function Affiche(AuthorRepository $repo){
     $obj=$repo->findAll();
     return $this->render('author/AfficheAuthor.html.twig',
     ['o'=>$obj]);
    }
    #[Route('/AuthorDetails/{ii}', name:'dd')]
    function AuthorDetails($ii){
        
        return $this->render('author/showAuthor.html.twig',
        ['i'=>$ii, 'auth'=>$this->authors]);
    }
    #[Route('/DetailAuthor/{id}',name:'Detail')]
    function DetailAuthor($id,AuthorRepository $repo){
        $obj=$repo->find($id);
        return $this->render(
            'author/DetailAuthor.html.twig',
        ['o'=>$obj]);

    }
    #[Route('/DeleteAuthor/{id}',name:'Delete')]
    function DeleteAuthor($id,AuthorRepository $repo,ManagerRegistry $manager){
        $obj=$repo->find($id);
        $em=$manager->getManager();
        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('Aff');
   
    }
    #[Route('/Ajout')]
    function AJoutAuthor(ManagerRegistry $manager){
        $obj=new Author();
        $obj->setUsername('');
        $obj->setEmail('');
        $em=$manager->getManager();
        $em->persist($obj);
        $em->flush();
        return $this->redirectToRoute('Aff');
        // return new Response('Ajout avec succé!');

    }
  
}
