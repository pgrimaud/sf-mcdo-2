<?php

namespace App\DataFixtures;

use App\Entity\District;
use App\Entity\Product;
use App\Entity\ProductRestaurant;
use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $district = new District();
            $district->setName('Paris ' . $i);
            $district->setPopulation(rand(50000, 200000));

            $manager->persist($district);

            for ($j = 0; $j < 10; $j++) {
                $restaurant = new Restaurant();
                $restaurant->setName('McDo #' . $i * ($j + 1));
                $restaurant->setDistrict($district);

                $manager->persist($restaurant);
            }
        }

        $manager->flush();

        $products = ['Cheeseburger', 'Mc Chicken', 'Big Mac', 'Mc Wrap', 'Frites',
            'Potatoes', 'Nuggets x6', 'Nuggets x9', 'Nuggets x20', 'Sundae'];

        foreach ($products as $product) {
            $productEntity = new Product();
            $productEntity->setName($product);

            $manager->persist($productEntity);
        }

        $manager->flush();

        $restaurantRepository = $manager->getRepository(Restaurant::class);
        $productRepository = $manager->getRepository(Product::class);

        $allRestaurants = $restaurantRepository->findAll();
        $allProducts = $productRepository->findAll();

        foreach ($allRestaurants as $restaurant) {
            foreach ($allProducts as $product) {
                $productRestaurant = new ProductRestaurant();
                $productRestaurant->setRestaurant($restaurant);
                $productRestaurant->setProduct($product);
                $productRestaurant->setStock(rand(50, 500));
                $productRestaurant->setPrice(rand(100, 1000) / 100);

                $manager->persist($productRestaurant);
            }
        }

        $manager->flush();

        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setEmail('test' . $i . '@gmail.com');
            $user->setRoles([
                'ROLE_USER',
                'ROLE_ADMIN',
            ]);
            $password = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
