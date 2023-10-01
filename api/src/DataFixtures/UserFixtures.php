<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $seedData = [ 
            0 => ["username" => "john" , "password"=> "123", "employeeId" => 1],
            1 => ["username" => "stuat" , "password"=> "123", "employeeId" => 2],
            2 => ["username" => "chris" , "password"=> "123", "employeeId" => 3],
        ];

        for ($i = 0; $i < count($seedData); $i++) {
            
            $user = new User();
            $user->setUsername($seedData[$i]["username"]);
            $password = $this->hasher->hashPassword($user, $seedData[$i]["password"]);
            $user->setPassword($password);
            $user->setRoles(['ROLE_EMPLOYEE']);
            $user->setEmployeeId($seedData[$i]["employeeId"]);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
