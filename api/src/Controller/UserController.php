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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Employee;
use App\Services\NixillaJWTEncoder;


/**
 * @Rest\Route("/api")
 */
#[Route('/api', name: 'api_')]
final class UserController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var SerializerInterface */
    private $serializer;

    /** @var NixillaJWTEncoder */
    private $JWTManager;

    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, UserPasswordHasherInterface $hasher, NixillaJWTEncoder $JWTManager)
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->hasher = $hasher;
        $this->JWTManager = $JWTManager;
    }


    /**
     * Authenticate the user
     */
    #[Route('/login', name: 'login_check', methods:['post'] )]
    public function login(#[CurrentUser] ?User $user, ManagerRegistry $doctrine, Request $request, Security $security): Response
    {
        $json = $request->getContent();
        $params = json_decode($json);
        $username = (isset($params->username)) ? $params->username : null;
        $password = (isset($params->password)) ? $params->password : null;
        $getHash = (isset($params->getHash)) ? $params->getHash : null;

        if ($username == null ) {
            throw new BadRequestHttpException('username cannot be empty');
        }

        if ($password == null ) {
            throw new BadRequestHttpException('password cannot be empty');
        }
        
        $user = $this->em->getRepository(User::class)->findOneBy(array(
            'username' => $username
        ));

        if (empty($user)) {
            throw new BadRequestHttpException('the given username or password is incorrect');
        }

        $isValid = $this->hasher->isPasswordValid($user, $password);

        if (!$isValid) {
            throw new BadRequestHttpException('the given username or password is incorrect');
        }

        // progamatically login the user
        $security->login($user);
        // generate the token
        $tokenData = array(
            "sub" => $user->getId(),
            "username" => $user->getUsername(),
            "iat" => time(),
            "exp" => time() + (60*60*24)
        );

        $token = $this->JWTManager->encode($tokenData);
        return new JsonResponse(["token" => $token, "employeeId" => $user->getEmployeeId()], Response::HTTP_OK, [], false);
        
    }
}