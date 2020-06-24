<?php

namespace App\Controller;

use App\Entity\Article;

use Knp\Component\Pager\PaginatorInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class HomeController extends AbstractController
{
      /**
      * @Route("/", name="home")
      */
      public function home(Request $request, PaginatorInterface $paginator)
      {
          $data = $this->getDoctrine()->getRepository(Article::class)->findAll();
          $articles = $paginator->paginate(
              $data, // Requête contenant les données à paginer (ici nos articles)
              $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
              10 // Nombre de résultats par page
          );
          return $this->render('home/index.html.twig', [
              'articles' => $articles
          ]);
      }
}
