<?php
/*
 * Mental Space Project - Creative Commons License
 */

namespace App\Test\TestCase\Action\Users;

use App\Moebius\Definition;
use App\Test\Fixture\UserFixture;
use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Users\UserReadAction
 */
class UserReadActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testValidId(): void
    {
        $this->insertFixtures([UserFixture::class]);

        $request = $this->createRequest(
            'POST',
            '/login',
            [
                'username' => 'valid@user.com',
                'password' => 'valid_password'
            ]
        );

        $response = $this->app->handle($request);
        $data = $response->getBody();



        $request = $this->createRequest('GET', '/api/user/detail/2');
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(
            [
                'id' => 2,
                'first_name' => 'tizio',
                'last_name' => 'caio',
                'email' => 'user@example.com',
                'locale' => 'it_IT',
            ],
            $response
        );
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInvalidId(): void
    {

        $request = $this->createRequest(
            'POST',
            '/login',
            [
                'username' => 'admin@example.com',
                'password' => 'password'
            ]
        );
        $response = $this->app->handle($request);
        $data = $response->getBody();


        $request = $this->createRequest('GET', '/api/user/detail/99');
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
