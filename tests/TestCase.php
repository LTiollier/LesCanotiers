<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseTransactions;

    /**
     * Ajax headers
     * @var array
     */
    protected $ajaxHeaders = [
        'HTTP_X-Requested-With' => 'XMLHttpRequest'
    ];

    /**
     * @param \App\Models\User|null $user
     * @return \Tests\TestCase
     */
    public function actingAsUser(User $user = null)
    {
        $user = $user ?: User::factory()->create();
        return $this->actingAs($user);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    protected function ajaxPost($uri, array $data = [], array $headers = [])
    {
        $headers = array_merge($this->ajaxHeaders, $headers);
        return $this->json('POST', $uri, $data, $headers);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    protected function ajaxGet($uri, array $data = [], array $headers = [])
    {
        $headers = array_merge($this->ajaxHeaders, $headers);
        return $this->json('GET', $uri, $data, $headers);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    protected function ajaxPut($uri, array $data = [], array $headers = [])
    {
        $headers = array_merge($this->ajaxHeaders, $headers);
        return $this->json('PUT', $uri, $data, $headers);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    protected function ajaxDelete($uri, array $data = [], array $headers = [])
    {
        $headers = array_merge($this->ajaxHeaders, $headers);
        return $this->json('DELETE', $uri, $data, $headers);
    }
}
