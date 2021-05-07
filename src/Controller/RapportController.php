<?php

namespace App\Controller;

use App\Repository\JEUNERepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RapportController extends AbstractController
{
    private $JeuneLayerData;
    public  function __construct(JEUNERepository $jeune)
    {
        $this->JeuneLayerData = $jeune;
    }


    #[Route('/rapport', name: 'rapport')]
    public function index(): Response
    {
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
        ]);
    }


    #[Route('/TotalJeuneByGroupe', name: 'TotalJeuneByGroupe')]
    public function GetTotalJeune(): array
    {

        $totalJeune = $this->JeuneLayerData->GetTotalJeuneByGroup();

    }


    #[Route('/TotalJeuneByGroupe', name: 'TotalJeuneByGroupe')]
    public function GetTotalJeuneByGroupe(JEUNERepository $jeuneData): Response
    {
        $result = $jeuneData->GetTotalJeuneByGroup();
        // $totalJeune = $jeuneData->GetTotalJeune();
        return $this->render('rapport/index.html.twig', [
            'totalJeune' => $result[0],
        ]);
    }
}
