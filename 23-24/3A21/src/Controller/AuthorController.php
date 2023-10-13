<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    }
}
