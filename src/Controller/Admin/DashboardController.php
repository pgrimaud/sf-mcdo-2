<?php

namespace App\Controller\Admin;

use App\Entity\District;
use App\Entity\Product;
use App\Entity\ProductRestaurant;
use App\Entity\Restaurant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('McDo Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Core');
        yield MenuItem::linkToCrud('Districts', 'fas fa-building', District::class);
        yield MenuItem::linkToCrud('Restaurants', 'fas fa-utensils', Restaurant::class);
        yield MenuItem::section('Stuff');
        yield MenuItem::linkToCrud('Products', 'fas fa-hamburger', Product::class);
        yield MenuItem::section('Stocks & Prices');
        yield MenuItem::linkToCrud('Product restaurants', 'fas fa-random', ProductRestaurant::class);
    }
}
