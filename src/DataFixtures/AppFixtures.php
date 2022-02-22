<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Header;
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
    private array $categories = [];
    private array $users = [];
    private array $orders = [];

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadCategories($manager);
        $this->loadProducts($manager);
        $this->loadAddresses($manager);
        $this->loadCarriers($manager);
        $this->loadOrders($manager);
        $this->loadOrdersDetails($manager);
        $this->loadHeaders($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$password, $email, $roles]) {
            $user = new User();
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setIsVerified(true);
            $manager->persist($user);
            $this->users[] = $user;
        }
        $manager->flush();
    }

    private function loadCategories(ObjectManager $manager): void
    {
        foreach ($this->getCategoryData() as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->categories[] = $category;
        }
        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager): void
    {
        foreach ($this->getProductData() as [$name, $slug, $illustration, $description, $price, $category, $isBest]) {
            $product = new Product();
            $product->setName($name)
                ->setSlug($slug)
                ->setIllustration($illustration)
                ->setDescription($description)
                ->setPrice($price)
                ->setCategory($this->categories[$category])
                ->setIsBest($isBest);
            $manager->persist($product);
        }
        $manager->flush();
    }

    private function loadAddresses(ObjectManager $manager): void
    {
        foreach ($this->getAddressData() as [$user, $name, $firstname, $lastname, $company, $address, $postal, $city, $country, $phone]) {
            $address = new Address();
            $address->setUser($this->users[$user])
                ->setName($name)
                ->setfirstname($firstname)
                ->setLastname($lastname)
                ->setCompany($company)
                ->setAddress($address)
                ->setPostal($postal)
                ->setCity($city)
                ->setCountry($country)
                ->setPhone($phone);
            $manager->persist($address);
        }
        $manager->flush();
    }

    private function loadCarriers(ObjectManager $manager): void
    {
        foreach ($this->getCarrierData() as [$name, $description, $price]) {
            $carrier = new Carrier();
            $carrier->setName($name)
                ->setDescription($description)
                ->setPrice($price);
            $manager->persist($carrier);
        }
        $manager->flush();
    }

    private function loadOrders(ObjectManager $manager): void
    {
        foreach ($this->getOrderData() as [$user, $carrierName, $carrierPrice, $delivery, $state]) {
            $order = new Order();
            $dayDate = new DateTimeImmutable();
            $reference = $dayDate->format('dmY') . '' . uniqid();
            $order->setUser($this->users[$user])
                ->setCreatedAt($dayDate)
                ->setCarrierName($carrierName)
                ->setCarrierPrice($carrierPrice)
                ->setDelivery($delivery)
                ->setState($state)
                ->setReference($reference);
            $manager->persist($order);
            $this->orders[] = $order;
        }
        $manager->flush();
    }

    private function loadOrdersDetails(ObjectManager $manager): void
    {
        foreach ($this->getOrderDetailsData() as [$myOrder, $product, $quantity, $price]) {
            $orderDetails = new OrderDetails();
            $orderDetails->setMyOrder($this->orders[$myOrder])
                ->setProduct($product)
                ->setQuantity($quantity)
                ->setPrice($price)
                ->setTotal($orderDetails->getPrice() * $orderDetails->getQuantity());
            $manager->persist($orderDetails);
        }
        $manager->flush();
    }

    public function loadHeaders(ObjectManager $manager): void
    {
        foreach ($this->getHeaderData() as [$title, $content, $btnTitle, $btnUrl, $illustration]) {
            $header = new Header();
            $header->setTitle($title)
                ->setContent($content)
                ->setBtnTitle($btnTitle)
                ->setBtnUrl($btnUrl)
                ->setIllustration($illustration);
            $manager->persist($header);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$password, $email, $roles];
            ['123456', 'foo@gmail.com', ['ROLE_USER']],
            ['123456', 'bar@gmail.com', ['ROLE_ADMIN']],
        ];
    }

    private function getCategoryData(): array
    {
        return ['Jeu Neuf', 'Jeu Occasion', 'Katana', 'Goodies', 'Figurine'];
    }

    private function getProductData(): array
    {
        return [
            // $productData = [$name, $slug, $illustration, $description, $price, $category, $isBest];
            ['PS5 kimetsu no yaiba the hinokami chronicles', 'ps5-kimetsu-no-yaiba-the-hinokami-chronicles', '7rK3P5yvB.jpg', 'Demon Slayer: Kimetsu no Yaiba - The Hinokami Chronicles est un jeu vidéo d\'action-aventure développé par CyberConnect2 et édité par Aniplex au Japon.', 5999, 0, 0],
            ['PS5 Grand Threft Auto 5', 'ps5-grand-threft-auto-5', '5hCsZj27K.jpg', 'Grand Theft Auto V est un jeu vidéo d\'action-aventure, développé par Rockstar North et édité par Rockstar Games.', 7999, 0, 1],
            ['Katana de Tanjirō Kamado – Demon Slayer', 'katana-de-tanjirō-kamado–Demon-Slayer', 't3MQ4aX2d.jpg', 'Superbe réplique du katana de Tanjirō Kamado personnage principale dans le manga Demon Slayer.', 4999, 2, 1],
            ['Carnet Death Note', 'carnet-death-note', 'p5SLfw65M.jpg', 'Superbe réplique du carnet Death Note.', 1699, 3, 0],
            ['PS4 Red dead redemption 2', 'ps4-red-dead-redemption-2', '8Xs25RzwW.jpg', 'Red Dead Redemption II est un jeu vidéo d\'action-aventure et de western multiplateforme, développé par Rockstar Studios et édité par Rockstar Games.', 1999, 1, 1],
            ['PS4 Minecraft', 'ps4-minecraft', 'cF22wUY3t.jpg', 'Minecraft est un jeu vidéo de type aventure « bac à sable » développé par le Suédois Markus Persson, alias Notch, puis par la société Mojang Studios.', 1999, 0, 1],
            ['Funko Pop Games Of Thrones Jon Snow', 'funko-pop-games-of-thrones-jon-snow', 'D87Vix2Zy.jpg', 'Figurine Funko Pop! N°07 - Game Of Thrones, Dans la saga Game Of Thrones, Jon Snow est le fils illégitime d\'Eddard Stark. Son père a toujours gardé l\'identité de sa mère secrète.', 999, 4, 0],
        ];
    }

    private function getAddressData(): array
    {
        return [
            //[$user, $name, $firstname, $lastname, $company, $address, $postal, $city, $country, $phone]
            [0, 'Maison', 'Gautier', 'Deschelles', 'Vide', '5 Rue du Muguet Vert', '02100', 'Saint Quentin', 'France', '0620278889']
        ];
    }

    private function getCarrierData(): array
    {
        return [
            //[$name, $description, $price]
            ['Colissimo', 'Livraison en 48h.', 799],
            ['Chronopost', 'Livraison en 24h.', 1490]
        ];
    }

    private function getOrderData(): array
    {
        return [
            //[$user, $carrierName, $carrierPrice, $delivery, $state]
            [0, 'Colissimo', 799, '5 Rue du Muguet Vert 02100 Saint Quentin', 1]
        ];
    }

    private function getOrderDetailsData(): array
    {
        return [
            //[$myOrder, $product, $quantity, $price]
            [0, 'PS5 Grand Threft Auto 5', 1, 7999]
        ];
    }

    private function getHeaderData(): array
    {
        return [
            //[$title, $content, $btnTitle, $btnUrl, $illustration]
            ['Gros arrivage', 'Accédez à un catalogue de jeux, figurines et autres goodies neufs et d\'occasions règulièrement enrichi.', 'Découvrir', 'https://127.0.0.1:8000/nos-produits', 'slide_1.jpg'],
            ['Nouveautés PS5', 'Découvrez Grand Theft Auto: The Trilogy – The Definitive Edition en version remasterisée.', 'Achetez maintenant', 'https://127.0.0.1:8000/produit/ps5-grand-threft-auto-5', 'slide_2.jpg'],
        ];
    }
}
