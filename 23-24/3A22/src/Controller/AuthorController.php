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
    #[Route('/showAuthor/{i}', name: 'show')]
    public function showAuthor($i)
    {
        return $this->render('author/showAuthor.html.twig',
            ['id' => $i,
             'authors'=>$this->authors]);

    }
    #[Route('/listAuthor', name:'list_Author')]
    function listAuthor(AuthorRepository $repo){
        $authors=$repo->findAll();
        // var_dump($authors);
        return $this->render('author/listAuthor.html.twig',
        ['aa'=>$authors]);
    }
    #[Route('/DetailAuthor/{ii}',name:'AuthorDetail')]
    function DetailAuthor($ii, AuthorRepository $repo){
        $auth=$repo->find($ii);
        // var_dump($auth);
        return $this->render('author/DetailAuthor.html.twig',
        ['aa'=>$auth]);
    }
    #[Route('/DeleteAuthor/{id}',name:'Delete_Author')]
    function DeleteAuthor(ManagerRegistry $manager,AuthorRepository $repo,$id){
        $em=$manager->getManager();
        #findID from repo
        $auth=$repo->find($id);
        #EntityManger
        #$em->remove(obj) via ID
        $em->remove($auth);
        #$em->flush()
        $em->flush();
        return $this->redirectToRoute('list_Author');
    }
}
