<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref',IntegerType::class)
            ->add('title')
            ->add('category',ChoiceType::class,[
                'choices'=>[
                    'Science Fiction'=>'SF',
                    'M'=>'Mystery',
                    'R'=>'Romance'
                ]
            ])
            ->add('publicationDate')
            ->add('author',EntityType::class,
            [
                'class'=>'App\Entity\Author',
                'choice_label'=>'username',
                // 'placeholder'=>'select an author',
                // 'expanded'=>True,
                //  'multiple'=>True
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
