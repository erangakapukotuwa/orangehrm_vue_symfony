<?php
namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $seedData = [ 
            0 => ["firstName" => "John" , "lastName"=> "McCane", "address" => "12, ABC Street, Colombo"],
            1 => ["firstName" => "Stuat" , "lastName"=> "Broad", "address" => "23, ABC Street, Colombo 7"],
            2 => ["firstName" => "Chris" , "lastName"=> "Moris", "address" => "3, ABC Street, Colombo 4"] 
        ];
        
        for ($i = 0; $i < count($seedData); $i++) {
            $employee = new Employee();
            $employee->setFirstName($seedData[$i]["firstName"]);
            $employee->setLastName($seedData[$i]["lastName"]);
            $employee->setAddress($seedData[$i]["address"]);
            $manager->persist($employee);
        }

        $manager->flush();
    }
}