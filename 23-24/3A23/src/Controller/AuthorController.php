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
    #[Route('/showAuthor/{name}', name: 'author_showname')]
    function showAuthor($name){
        return $this->render(
        'author/show.html.twig',
        ['n'=>$name]);
    }
    #[Route('/list', name:"testlist")]
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
    #[Route('/AuthorDetails/{ii}', name:'author_details')]
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
    function Ajout(ManagerRegistry $manager){
        $obj=new Author();
        $obj->setUsername('Ahmed Ben Said');
        $obj->setEmail('Ahmed.bensaid@sprit.tn');
        $em=$manager->getManager();
        $em->persist($obj);
        $em->flush();
        // return $this->redirectToRoute('Aff');
        return new Response('Ajout avec succé!');
    }
    #[Route('/AjoutAuthor')]
    function AjoutAuthor(ManagerRegistry $manager,Request $request){
        // 3-
        $author=new Author();
        // $obj->setUsername('Ahmed Ben Said');
        // $obj->setEmail('Ahmed.bensaid@sprit.tn');
        //Appeler Formulaire
        // 2-
        $form=$this->createForm(AuthorType::class,$author)
        ->add('Ajout',SubmitType::class);
        // 4-
        $form->handleRequest($request);
        // 5-
        if($form->isSubmitted() && $form->isValid()){
            // 6-
            $em=$manager->getManager();
            // 7-
            $em->persist($author);
            $em->flush();
            // 8- 
            return $this->redirectToRoute('Aff');
        }
        // 1-
        return $this->renderForm('author/Ajout.html.twig',
                                ['ff'=>$form]);
        // return $this->render('author/Ajout.html.twig',
        //                         ['ff'=>$form->createView()]);
    }
  
}
