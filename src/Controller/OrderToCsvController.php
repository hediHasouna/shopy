<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use App\Entity\Article;

class OrderToCsvController extends AbstractController
{
    public function index(): Response
    {
        //récupération du commandes
        $repository = $this->getDoctrine()->getRepository(commande::class);
        $commandes = $repository->findAll();

        //récupération d'articles
        $repository = $this->getDoctrine()->getRepository(article::class);
        $articles = $repository->findAll();

        //l'ajout du nouvelle commande
        if(isset($_POST['orderId']))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $commande = new Commande();
            $commande->setOrderId($_POST['orderId']);
            $commande->setDeliveryName($_POST['deliveryName']);
            $commande->setDeliveryAdresse($_POST['deliveryAdresse']);
            $commande->setDeliveryCountry($_POST['deliveryCountry']);
            $commande->setDeliveryZipCode($_POST['zipcode']);
            $commande->setDeliveryCity($_POST['deliveryCity']);

            $entityManager->persist($commande);
            $entityManager->flush();
        }
        
        //modification du commande
        if(isset($_POST['hiddenValue']))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $commande = $entityManager->getRepository(Commande::class)->find($_POST['hiddenValue']);
            $commande->setOrderId($_POST['orderIdEdit']);
            $commande->setDeliveryName($_POST['deliveryNameEdit']);
            $commande->setDeliveryAdresse($_POST['deliveryAdresseEdit']);
            $commande->setDeliveryCountry($_POST['deliveryCountryEdit']);
            $commande->setDeliveryZipCode($_POST['zipcodeEdit']);
            $commande->setDeliveryCity($_POST['deliveryCityEdit']);

            $entityManager->persist($commande);
            $entityManager->flush();
        }

        //l'ajout du nouvel article
        if(isset($_POST['itemId']))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $commande = $entityManager->getRepository(Commande::class)->find($_POST['commande']);
            $article = new Article();
            $article -> setItemId($_POST['itemId']);
            $article -> setItemQuantity($_POST['itemQuantity']);
            $article -> setLinePriceExclVat($_POST['linePriceExclVat']);
            $article -> setLinePriceInclVat($_POST['linePriceInclVat']);
            $article -> setIdCommande($commande);
            $entityManager->persist($article);
            $entityManager->flush();
        }

        //modification d'un article
        if(isset($_POST['hiddenArticle']))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $article = $entityManager->getRepository(Article::class)->find($_POST['hiddenArticle']);
            $commande = $entityManager->getRepository(Commande::class)->find($_POST['CommandeEdit']);
            $article -> setItemId($_POST['itemIdEdit']);
            $article -> setItemQuantity($_POST['itemQuantityEdit']);
            $article -> setLinePriceExclVat($_POST['linePriceExclVatEdit']);
            $article -> setLinePriceInclVat($_POST['linePriceInclVatEdit']);
            $article -> setIdCommande($commande);
            $entityManager->persist($article);
            $entityManager->flush();
        }

        //la suppression d'article
        if(isset($_POST['idArticle']))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $article = $entityManager->getRepository(Article::class)->find($_POST['idArticle']);
            $entityManager->remove($article);
            $entityManager->flush();
            echo("ok");
        }

        //la suppression du commande
        if(isset($_POST['idCommande']))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $commande = $entityManager->getRepository(Commande::class)->find($_POST['idCommande']); 
            $articles = $entityManager->getRepository(Article::class)->findBy(['idCommande' => $commande->getId()]);
            //vérifier s'il y a des articles
            if($articles)
            {
                //si oui suppression d'articles liés au commande
                foreach($articles as $article)
                 {
                    $entityManager->remove($article);
                }
            }
            //suppression du commande
            $entityManager->remove($commande);
            $entityManager->flush();
            echo("ok");
        }

        return $this->render('orderToCsv/index.html.twig', [
            'commandes' => $commandes,
            'articles'  => $articles
        ]);
    }
}
