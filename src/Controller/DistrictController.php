<?php

namespace App\Controller;

use App\Repository\DistrictRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistrictController extends AbstractController
{
    #[Route('/districts', name: 'app_districts')]
    public function index(DistrictRepository $districtRepository): Response
    {
        return $this->render('district/index.html.twig', [
            'districts' => $districtRepository->findAll(),
        ]);
    }
}
