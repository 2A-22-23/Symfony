<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Author;
use App\Form\AuthorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/autor')]
class AutorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => '/images/ESPRIT.jpg',
        'username' => 'Victor Hugo', 'email' =>'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/ESPRIT.jpg',
        'username' => ' William Shakespeare', 'email' =>' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/ESPRIT.jpg',
        'username' => 'Taha Hussein', 'email' =>'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/index', name: 'app_autor')]
    public function index(): Response
    {
        return $this->render('autor/index.html.twig', [
            'controller_name' => 'AutorController',
        ]);
    }
    #[Route('/res/{classe}')]
    function response($classe){
        return new Response("Bonjour <i>".$classe."</i>");
    }
    #[Route('/list')]
    function list(){
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg',
            'username' => 'Victor Hugo', 'email' =>'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg',
            'username' => ' William Shakespeare', 'email' =>' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg',
            'username' => 'Taha Hussein', 'email' =>'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            return $this->render('autor/list.html.twig',
        ['auth'=>$authors]);
    }
    #[Route('/Details/{i}', name:'DD')]
    function AuthorDetails($i){
       
        return $this->render('autor/details.html.twig',
        ['ii'=>$i,'aa'=>$this->authors]);
    }
    #[Route('/Affiche',name:"Aff")]
    function Affiche(AuthorRepository $repo){
        $authors=$repo->findAll();
        return $this->render('autor/listAuthor.html.twig',
        ['aa'=>$authors]);
    }
    #[Route('/DetailAuthor/{id}',name:"Detail")]
    function DetailAuthor($id,AuthorRepository $repo){
        $author=$repo->find($id);
        return $this->render('autor/DetailAuthor.html.twig',
        ['auteur'=>$author]);
    }
    #[Route('DeleteAuthor/{id}',name:'Delete')]
    function DeleteAuthor($id,ManagerRegistry $manager,AuthorRepository $repo){
        $em=$manager->getManager();
        $objAuteur=$repo->find($id);
        $em->remove($objAuteur);
        $em->flush();
        
        return $this->redirectToRoute('Aff');
    }
    #[Route('/Ajout')]
    function AjouterAuthor(ManagerRegistry $manager){
        $em=$manager->getManager();//$em = entity Manager
        $author= new Author;
        $author->setUsername('ahmed');
        $author->setEmail('a@esprit.tn');
        $em->persist($author);
        $em->flush();
        // return $this->redirectToRoute('Aff');
        return new Response("L'objet est ajouté");

    }
    #[Route('/Add')]
    function AddAuthor(Request $request,ManagerRegistry $manager){
       $author= new Author;
        #Formulaire
        $form=$this->createForm(AuthorType::class,$author)
        ->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
            $em=$manager->getManager();//$em = entity Manager
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('Aff');
       }
        #Afficher formulaire sous forme de twig
       return $this->renderForm(
        'autor/Ajout.html.twig',['ff'=>$form]);
    }
    #[Route('/AfficheQB',name:"Aff")]
    function AfficheQB(AuthorRepository $repo){
        $authors=$repo->OrderByEmail();
        return $this->render('autor/listAuthor.html.twig',
        ['aa'=>$authors]);
    }
}
