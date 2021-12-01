<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Product;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    private $categoriesData = ['Jeu Neuf', 'Jeu Occasion', 'Katana', 'Goodies', 'Figurine'];

    private $productsData = [
        1 => [
            'name' => 'PS5 kimetsu no yaiba the hinokami chronicles',
            'slug' => 'ps5-kimetsu-no-yaiba-the-hinokami-chronicles',
            'illustration' => '7rK3P5yvB.jpg',
            'description' => 'Demon Slayer: Kimetsu no Yaiba - The Hinokami Chronicles est un jeu vidéo d\'action-aventure développé par CyberConnect2 et édité par Aniplex au Japon.',
            'price' => 5999,
            'category' => 0
        ],
        2 => [
            'name' => 'PS5 Grand Threft Auto 5',
            'slug' => 'ps5-grand-threft-auto-5',
            'illustration' => '5hCsZj27K.jpg',
            'description' => 'Grand Theft Auto V est un jeu vidéo d\'action-aventure, développé par Rockstar North et édité par Rockstar Games.',
            'price' => 7999,
            'category' => 0
        ],
        3 => [
            'name' => 'Katana de Tanjirō Kamado – Demon Slayer',
            'slug' => 'katana-de-tanjirō-kamado–Demon-Slayer',
            'illustration' => 't3MQ4aX2d.jpg',
            'description' => 'Superbe réplique du katana de Tanjirō Kamado personnage principale dans le manga Demon Slayer.',
            'price' => 4999,
            'category' => 2
        ],
        4 => [
            'name' => 'Carnet Death Note',
            'slug' => 'carnet-death-note',
            'illustration' => 'p5SLfw65M.jpg',
            'description' => 'Superbe réplique du carnet Death Note.',
            'price' => 1699,
            'category' => 3
        ],
        5 => [
            'name' => 'PS4 Red dead redemption 2',
            'slug' => 'ps4-red-dead-redemption-2',
            'illustration' => '8Xs25RzwW.jpg',
            'description' => 'Red Dead Redemption II est un jeu vidéo d\'action-aventure et de western multiplateforme, développé par Rockstar Studios et édité par Rockstar Games.',
            'price' => 1999,
            'category' => 1
        ],
        6 => [
            'name' => 'PS4 Minecraft',
            'slug' => 'ps4-minecraft',
            'illustration' => 'cF22wUY3t.jpg',
            'description' => 'Minecraft est un jeu vidéo de type aventure « bac à sable » développé par le Suédois Markus Persson, alias Notch, puis par la société Mojang Studios.',
            'price' => 1999,
            'category' => 0
        ],
        7 => [
            'name' => 'Funko Pop Games Of Thrones Jon Snow',
            'slug' => 'funko-pop-games-of-thrones-jon-snow',
            'illustration' => 'D87Vix2Zy.jpg',
            'description' => 'Figurine Funko Pop! N°07 - Game Of Thrones, Dans la saga Game Of Thrones, Jon Snow est le fils illégitime d\'Eddard Stark. Son père a toujours gardé l\'identité de sa mère secrète.',
            'price' => 999,
            'category' => 4
        ],
    ];

    private $carriersData = [
        1 => [
            'name' => 'Colissimo',
            'description' => 'Livraison en 48h.',
            'price' => 799
        ],
        2 => [
            'name' => 'Chronopost',
            'description' => 'Livraison en 24h.',
            'price' => 1490
        ],
    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Add 1 basic User
        $user = new User();
        $user->setEmail('foo@gmail.com');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            '123456'
        ));
        $user->setIsVerified(true);

        $manager->persist($user);

        // Add 1 administator User
        $admin = new User();
        $admin->setEmail('bar@ecommerce.com');
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->passwordHasher->hashPassword(
            $admin,
            '123456'
        ));
        $admin->setIsVerified(true);

        $manager->persist($admin);

        // Add 5 Category
        $categories = [];
        foreach ($this->categoriesData as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Create 7 Product
        foreach ($this->productsData as $key => $value) {
            $product = new Product();
            $product->setName($value['name'])
                ->setSlug($value['slug'])
                ->setIllustration($value['illustration'])
                ->setDescription($value['description'])
                ->setPrice($value['price'])
                ->setCategory($categories[$value['category']]);

            $manager->persist($product);
        }

        // Add 1 Address
        $address = new Address();
        $address->setUser($user)
            ->setName('Magasin')
            ->setfirstname('Gautier')
            ->setLastname('Deschelles')
            ->setCompany('Console et Jeu')
            ->setAddress('5 Rue du Muguet Vert')
            ->setPostal('02100')
            ->setCity('Saint Quentin')
            ->setCountry('France')
            ->setPhone('0620278889');

        $manager->persist($address);

        // Add 2 Carrier
        foreach ($this->carriersData as $key => $value) {
            $carrier = new Carrier();
            $carrier->setName($value['name'])
                ->setDescription($value['description'])
                ->setPrice($value['price']);

            $manager->persist($carrier);
        }

        // Add 1 Order
        $order = new Order();
        $dayDate = new DateTimeImmutable();
        $reference = $dayDate->format('dmY') . '' . uniqid();
        $order->setUser($user)
            ->setCreatedAt($dayDate)
            ->setCarrierName('Colissimo')
            ->setCarrierPrice(799)
            ->setDelivery('5 Rue du Muguet Vert 02100 Saint Quentin')
            ->setIsPaid(0)
            ->setReference($reference);

        $manager->persist($order);

        // Create 1 order details
        $orderDetails = new OrderDetails();
        $orderDetails->setMyOrder($order)
            ->setProduct('PS5 Grand Threft Auto 5')
            ->setQuantity(1)
            ->setPrice(7999)
            ->setTotal($orderDetails->getPrice() * $orderDetails->getQuantity());

        $manager->persist($orderDetails);

        $manager->flush();
    }
}
