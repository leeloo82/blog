<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

/*finstaller les librairie faker*/
use Faker\Factory;

class ArticleController extends AbstractController
{
    /*Input: taille du tableau
      Process: génère de manière aleatoire length fois des nombres aléatoire entre min et max dans un tableau
      Output: retourne le tableau avec les données
      note:
    */
    static function generateurTabNum($length){
        $min = 5;
        $max = 100;

        //intialisation du tableau de données
        $tableau = [];
        /*boucle de remplissage des data random dans le tableau*/
        for ($cpt=0;$cpt<$length;$cpt++){
            $random = rand($min,$max);
            $tableau[$cpt] = $random;
        }
        return $tableau;
    }

    /*Input:
     Process:
     Output: retourne le tableau avec les données
     note: faker n'est pas reconnu installé librairie
   */
    static function TabString(){

        //tableau de chaines de caractère
        $string =['banane','pomme','poire'];
        return $string;
    }

    /*Input:
      Process: transforme l'objet datetime sous format chaine de caractère via format->()
      Output: retourne la date
      note:
  */
    static function dateGenerateur(){

        $date = new DateTime('2022-11-20');

        return $date->format('Y-m-d');
    }

    /**
     * @Route("/tableau", name="app_tableau")
     */
    public function tableau(): Response
    {
        /*recupération des valeur retourner des fonction static*/
        $tableau = self::generateurTabNum(10);
        $string =self::TabString();
        $date =self::dateGenerateur();

        /*boucle de traiment pour rechercher la valeur max du tableau*/
        $valMax =$tableau[0];
        for($cpt=1;$cpt<10-1;$cpt++){

            if($tableau[$cpt] > $valMax){
                $valMax=$tableau[$cpt];
            }
        }

        return $this->render('article/tableau.html.twig', [
            'controller_article' => 'Article','tableau'=>$tableau,'string'=>$string,'valMax'=>$valMax,'date'=>$date,
        ]);

    }

    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response{
        $msg = "Welcom in my blog";
        return $this->render('article/index.html.twig', [
            'controller_article' => 'Article','msg'=>$msg,
        ]);
    }
    /**
     * @Route("/article", name="app_article")
     */
    public function article(): Response
    {
        return $this->render('article/article.html.twig', [
            'controller_article' => 'Article',
        ]);

    }
    /*input: prend l'id de l'article cible
     process: en fonction de l'id en paramètre va dans le bon cas et renvoie l'url de la page de l'article ciblé
     output: revoie l'adresse dela page demandé
     note: lorsque l'on devra aller chercher l'article dans la data base faire une boucle sur l'id tant que celui si n'est pas === a celui de la data base*/
    /**
     * @Route("/article/{id}", name="afficher_article")
     */
    public function display($id)
    {
        switch($id){
            case '1': $view = 'article/detail-article.html.twig';
                break;
            case '2': $view = 'article/apiculture.html.twig';
                break;
        }
        return $this->render($view);

    }
        /*input: string $action
         process: ajoute 1 ou retire un selon l'action
         output: retourne une variable avec la nouvelle valeur en json
         notes:
       // vote pour un article, retour en JSON pour une fonction ajax*/
   /**
     * @Route("article/vote/{action}", name="vote" )
     */
    public function votes(string $action): Response
    {

        if ($action === "up") {
            $retour = rand(5,10);
        } elseif ($action === "down" ) {
            $retour = rand(11,20);
        } else {
            //erreur
        }
        return new JsonResponse([
            'vote' => $retour
        ]);

    }

    /**
     * @Route("/article", name="app_article")
     */
    public function articleObject(EntityManagerInterface $entityManager)
    {

        $article = new Article();
        $article->setTitre('Mon article 3');
        $article->setContenu('MAGIQUE');
        $article->setDate(new DateTime(15-05-2016));

        $entityManager->persist($article);
        $entityManager->flush();

        //redirige vers la page
        return $this->render('article/article.html.twig', [
                   'controller_article' => 'Article',
               ]);

    }
}
