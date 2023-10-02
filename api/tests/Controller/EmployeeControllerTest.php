<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Safe\Exceptions\JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function count;

final class EmployeeControllerTest extends AbstractControllerKernelTestCase
{

    /**
     * @throws JsonException
     */
    public function testGet(): void
    {   
        $this->login();
        $this->client->request(Request::METHOD_GET, '/api/employee/1');
        $response = $this->client->getResponse();
        $content = $this->assertJSONResponse($response, Response::HTTP_OK);
        $this->assertEquals(1, $content["id"]);
    }
}