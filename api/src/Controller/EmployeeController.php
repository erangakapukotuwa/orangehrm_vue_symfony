<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employee;

/**
 * @Rest\Route("/api")
 */
#[Route('/api', name: 'api_')]
final class EmployeeController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }


    /**
     * get employee data by id
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    #[Route('/employee/{id}', name: 'get_one', methods:['get'] )]
    public function get(#[CurrentUser] ?User $user, ManagerRegistry $doctrine, int $id): JsonResponse
    {
        if (empty($id)) {
            throw new BadRequestHttpException('id cannot be empty');
        }
        $employee = $this->em->getRepository(Employee::class)->findOneBy(array(
            'id' => $id
        ));

        if (empty($employee)) {
            throw new BadRequestHttpException('can not find employee');
        }

        $data = $this->serializer->serialize($employee, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}