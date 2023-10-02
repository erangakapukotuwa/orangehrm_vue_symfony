<?php

declare(strict_types=1);

namespace App\Tests\Controller;


use Safe\Exceptions\JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use function Safe\json_decode;
use function Safe\json_encode;

abstract class AbstractControllerKernelTestCase extends WebTestCase
{
    /** @var KernelBrowser */
    protected $client;
    protected AbstractDatabaseTool $databaseTool;

    protected const DEFAULT_USER_LOGIN = 'john';
    protected const DEFAULT_USER_PASSWORD = '123';

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @param mixed[] $data
     * @throws JsonException
     */
    protected function JSONRequest(string $method, string $uri, array $data = []): void
    {
        $this->client->request($method, $uri, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
    }

    /**
     * @return mixed
     * @throws JsonException
     */
    protected function assertJSONResponse(Response $response, int $expectedStatusCode)
    {
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        return json_decode($response->getContent(), true);
    }

    protected function login(string $username = self::DEFAULT_USER_LOGIN, string $password = self::DEFAULT_USER_PASSWORD): void
    {   
        $this->client->request(Request::METHOD_POST, '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode(['username' => $username, 'password' => $password]));
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}