<?php

namespace App\Controller;

use App\Entity\OriginCountry;
use App\Form\OriginCountryType;
use App\Repository\OriginCountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/origin/country')]
final class OriginCountryController extends AbstractController
{
    #[Route(name: 'app_origin_country_index', methods: ['GET'])]
    public function index(OriginCountryRepository $originCountryRepository): Response
    {
        return $this->render('origin_country/index.html.twig', [
            'origin_countries' => $originCountryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_origin_country_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $originCountry = new OriginCountry();
        $form = $this->createForm(OriginCountryType::class, $originCountry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($originCountry);
            $entityManager->flush();

            return $this->redirectToRoute('app_origin_country_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('origin_country/new.html.twig', [
            'origin_country' => $originCountry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_origin_country_show', methods: ['GET'])]
    public function show(OriginCountry $originCountry): Response
    {
        return $this->render('origin_country/show.html.twig', [
            'origin_country' => $originCountry,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_origin_country_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OriginCountry $originCountry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OriginCountryType::class, $originCountry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_origin_country_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('origin_country/edit.html.twig', [
            'origin_country' => $originCountry,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_origin_country_delete', methods: ['POST'])]
    public function delete(Request $request, OriginCountry $originCountry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$originCountry->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($originCountry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_origin_country_index', [], Response::HTTP_SEE_OTHER);
    }
}
