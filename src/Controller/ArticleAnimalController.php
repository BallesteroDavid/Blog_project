<?php

namespace App\Controller;

use App\Entity\ArticleAnimal;
use App\Entity\Comment;
use App\Form\ArticleAnimalType;
use App\Form\CommentType;
use App\Repository\ArticleAnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article/animal')]
final class ArticleAnimalController extends AbstractController
{
    // accueil/index
    #[Route(name: 'app_article_animal_index', methods: ['GET'])]
    public function index(ArticleAnimalRepository $articleAnimalRepository): Response
    {
        return $this->render('article_animal/index.html.twig', [
            'article_animals' => $articleAnimalRepository->findAll(),
        ]);
    }

    // Ajout d'un d'article
    #[Route('/new', name: 'app_article_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articleAnimal = new ArticleAnimal();
        $form = $this->createForm(ArticleAnimalType::class, $articleAnimal);
        $form->handleRequest($request);

        // Si formulaire est soumis et valide 
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du fichier envoyé depuis formulaire
            $file = ($form->get('img')->getData());
            
            if($file){
                // Gérération d'un nouvea nom de fichier, plus ajout d'un timestamp devant le now du fichier
                $newFileName = time() . '-' . $file->getClientOriginalName();

                // Déplace le fichier uploadé dans le fichier défini
                $file->move($this->getParameter('articleAnimal_dir'), $newFileName);
                // Enrengistre le nom du fichier 
                $articleAnimal->setImg($newFileName);
            }
            $entityManager->persist($articleAnimal);
            $entityManager->flush();
            // Si ajout réussi, renvoi vers l'index
            return $this->redirectToRoute('app_article_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        // redirection vers la page de création
        return $this->render('article_animal/new.html.twig', [
            'article_animal' => $articleAnimal,
            'form' => $form,
        ]);
    }

    // Show de l'article
    #[Route('/{id}', name: 'app_article_animal_show', methods: ['GET'])]
    public function show(Request $request, ArticleAnimal $articleAnimal, EntityManagerInterface$em): Response
    {
        // Ajout commentaire
        $comment = new Comment();
        $comment->setarticleAnimal($articleAnimal);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('animal_show', ['id' => $articleAnimal->getId()]);
        }
        return $this->render('article_animal/show.html.twig', [
            'article_animal' => $articleAnimal,
            'commentForm' => $form->createView(),
        ]);
    }

    // Modification d'un article
    #[Route('/{id}/edit', name: 'app_article_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArticleAnimal $articleAnimal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleAnimalType::class, $articleAnimal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article_animal/edit.html.twig', [
            'article_animal' => $articleAnimal,
            'form' => $form,
        ]);
    }

    // suppression d'un article
    #[Route('/{id}', name: 'app_article_animal_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleAnimal $articleAnimal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleAnimal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($articleAnimal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}
