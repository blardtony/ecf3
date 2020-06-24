<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Marque;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/create", name="create_article")
     */
    public function create(Request $request)
    {
      $article = new Article;

      $form = $this->createFormBuilder($article)
      ->add('name', TextType::class, ['label' => "Nom de l'article"])
      ->add('description', TextareaType::class, ['label' => "Description"])
      ->add('reference', TextType::class, [
          'label' => "Référence",
          'attr' => [
            'minlength' => 10,
            'maxlength' => 10
          ]
      ])
      ->add('quantity', IntegerType::class, [
          'label' => "Quantité",
          'attr' => [
            'min' => 0
          ]
      ])
      ->add('marque', EntityType::class, [
            'label' => "Marque",
            'class' => Marque::class,
            'choice_label' => 'name',
      ])
      ->add('category', EntityType::class, [
            'label' => "Catégorie",
            'class' => Category::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => true,
      ])
      ->add('save', SubmitType::class, [
        'label' => 'Créer article',
        'attr' => [
          'class' => 'btn-success'
        ]
      ])
      ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        dump($form);
        return $this->redirectToRoute('home');
      }
        return $this->render('article/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/detail/{id}", name="detail_article")
    */
    public function detail($id)
    {
      $article = new Article;
      $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

      return $this->render('article/detail.html.twig', [
        'article' => $article,
      ]);
    }

    /**
     * @Route("/article/edit/{id}", name="edit_article")
     */
    public function edit(Request $request, $id)
    {
      $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

      $form = $this->createFormBuilder($article)
      ->add('name', TextType::class, ['label' => "Nom de l'article"])
      ->add('description', TextareaType::class, ['label' => "Description"])
      ->add('reference', TextType::class, [
          'label' => "Référence",
          'attr' => [
            'minlength' => 10,
            'maxlength' => 10
          ]
      ])
      ->add('quantity', IntegerType::class, [
          'label' => "Quantité",
          'attr' => [
            'min' => 0
          ]
      ])
      ->add('marque', EntityType::class, [
            'label' => "Marque",
            'class' => Marque::class,
            'choice_label' => 'name',
      ])
      ->add('category', EntityType::class, [
            'label' => "Catégorie",
            'class' => Category::class,
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => true,
      ])
      ->add('save', SubmitType::class, [
        'label' => 'Éditer article',
        'attr' => [
          'class' => 'btn-success'
        ]
      ])
      ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        dump($form);
        return $this->redirectToRoute('home');
      }
        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
