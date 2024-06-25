<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleStatus;
use App\Entity\Category;
use App\Entity\City;
use App\Entity\Client;
use App\Entity\Country;
use App\Entity\Employee;
use App\Entity\Item;
use App\Entity\Material;
use App\Entity\Order;
use App\Entity\PaymentMethod;
use App\Entity\Service;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const CATEGORIES = [
        "Clothing" => [
            "Pants" => [
                "Shorts",
                "Trousers"
            ],
            "Accessories" => [
                "Scarf",
                "Bonnet",
                "Socks",
                "Tie"
            ],
            "Suit",
            "Shirt",
            "Skirt",
            "Jacket",
            "T-shirt",
            "Underwear"
        ],
        "Home textile" => [
            "Bedding" => [
                "Sheets",
                "Pillowcase",
                "Blanket"
            ],
            "Towels",
            "Tablecloth",
            "Curtains",
            "Drapes",
            "Carpet"
        ]
    ];

    private const MATERIALS = [
        "Cotton",
        "Linen",
        "Wool",
        "Leather",
        "Synthetic",
        "Jeans"
    ];

    private const PAYMENT_METHODS = [
        "Credit Card",
        "On Place"
    ];

    private const SERVICES = [
        "Cleaning" => 4,
        "Ironing" => 2,
    ];

    private const ARTICLE_STATUS = [
        "Waiting for drop",
        "Cleaning",
        "Ready",
    ];

    private const COUNTRIES = [
        "France"
    ];

    private const CITIES = [
        "Lyon",
        "Paris",
        "Toulon",
        "Grenoble"
    ];

    private array $items = [];

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        $countryList = [];
        $cityList = [];
        $customerList = [];
        $empList = [];
        $orderList = [];
        $statusList = [];
        $materialList = [];
        $methodList = [];
        $serviceList = [];

        $this->loadCategories($manager, null, self::CATEGORIES);

        foreach (self::MATERIALS as $mat) {
            $material = new Material();
            $material->setName($mat)
                ->setCoefficient(1);

            $materialList[] = $material;

            $manager->persist($material);
        }

        foreach (self::PAYMENT_METHODS as $payMet) {
            $payment = new PaymentMethod();
            $payment->setName($payMet);

            $methodList[] = $payment;

            $manager->persist($payment);
        }

        foreach (self::SERVICES as $name => $price) {
            $service = new Service();
            $service->setName($name)
                ->setPrice($price)
                ->setDescription('Lorem Ipsum');

            $serviceList[] = $service;

            $manager->persist($service);
        }

        foreach (self::ARTICLE_STATUS as $stat) {
            $status = new ArticleStatus();
            $status->setName($stat);

            $statusList[] = $status;

            $manager->persist($status);
        }

        foreach (self::COUNTRIES as $coun) {
            $country = new Country();
            $country->setName($coun);

            $countryList[] = $country;

            $manager->persist($country);
        }

        foreach (self::CITIES as $cit) {
            $city = new City();
            $city->setName($cit)
                ->setCountry($countryList[0])
                ->setPostalCode($faker->numerify('#####'));

            $cityList[] = $city;
            $manager->persist($city);
        }

        for ($i = 0; $i < 20; $i++) {
            $customer = new Client();
            $customer->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setEmail($faker->safeEmail())
                ->setPassword('test')
                ->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'))
                ->setAddress($faker->buildingNumber() . ' ' . $faker->streetName())
                ->setPremium($faker->boolean(50))
                ->setClientNumber($faker->numerify('CLI-########'))
                ->setCity($faker->randomElement($cityList));

            $customerList[] = $customer;

            $manager->persist($customer);
        }

        for ($i = 0; $i < 3; $i++) {
            $employee = new Employee();
            $employee->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setEmail($faker->safeEmail())
                ->setPassword('employee')
                ->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'))
                ->setAddress($faker->buildingNumber() . ' ' . $faker->streetName())
                ->setEmployeeNumber($faker->numerify('EMP-########'))
                ->setCity($faker->randomElement($cityList))
                ->setRoles(['ROLE_EMPOLYEE']);

            $empList[] = $employee;

            $manager->persist($employee);
        }

        $admin = new User();
        $admin->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setCreatedAt($faker->dateTimeBetween('-2 years'))
            ->setEmail('admin@email.com')
            ->setPassword('admin')
            ->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'))
            ->setAddress($faker->buildingNumber() . ' ' . $faker->streetName())
            ->setCity($faker->randomElement($cityList))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($i = 0; $i < 30; $i++) {
            $order = new Order();
            $order->setClient($faker->randomElement($customerList))
                ->setCreatedAt($faker->dateTimeBetween('-1 years'))
                ->setDroppedAt($faker->dateTimeBetween($order->getCreatedAt()))
                ->setDeliveredAt($faker->randomElement([null, $order->getDroppedAt()])) // date client pick up/delivered
                ->setDelivery($faker->boolean(30)) // has to be delivered at home yes / no
                ->setPaymentMethod($faker->randomElement($methodList));

            if ($order->isDelivery()) {
                $order->setDeliveryAddress($order->getClient()->getAddress());
            }

            $orderList[] = $order;

            $manager->persist($order);
        }

        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setClientOrder($faker->randomElement($orderList))
                ->setEmployee($faker->randomElement($empList))
                ->setItem($faker->randomElement($this->items))
                ->setMaterial($faker->randomElement($materialList))
                ->setService($faker->randomElement($serviceList))
                ->setPrice($article->getService()->getPrice() * $article->getMaterial()->getCoefficient() * $article->getItem()->getCoefficient())
                ->setStatus($faker->randomElement($statusList));

            $manager->persist($article);
        }

        $manager->flush();
    }


    private function loadCategories(ObjectManager $manager, ?Category $parentCategory, array $categories)
    {
        $faker = \Faker\Factory::create();
        foreach ($categories as $key => $val) {
            $recursive = is_array($val);
            $categoryName = $recursive ? $key : $val;

            if (!$recursive) {
                $item = new Item();
                $item->setName($categoryName)
                    ->setCategory($parentCategory)
                    ->setCoefficient(1)
                    ->setDescription("Lorem Ipsum");

                $this->items[] = $item;

                $manager->persist($item);

            } else {
                $category = new Category();
                $category
                    ->setName($categoryName)
                    ->setParent($parentCategory);

                $manager->persist($category);

                $this->loadCategories($manager, $category, $val);
            }
        }
    }
}