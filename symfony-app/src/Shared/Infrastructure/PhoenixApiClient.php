<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Model\User;
use App\Shared\Domain\Repository\UserRepositoryInterface;
use App\Shared\Helper\ArrayHelper;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class PhoenixApiClient implements UserRepositoryInterface
{
    public function __construct(
        private string $apiHost,
        private string $apiPort,
        private string $apiToken,
        private HttpClientInterface $client
    ) {}

    /**
     * @return User[]
     */
    public function fetchUsers(array $filters): array
    {
        try {
            $response = $this->apiCall(
                'GET',
                '/users',
                [
                    'query' => ArrayHelper::keysToSnakeCase($filters),
                ]
            );
            $results = $this->parseResponse($response)['data']['results'];
            return array_map(
                fn (array $result) => User::fromArray($result),
                $results
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch users', 0, $e);
        }
    }

    public function createUser(array $data): void
    {
        try {
            $this->apiCall(
                'POST',
                '/users',
                [
                    'json' => ArrayHelper::keysToSnakeCase($data),
                ]
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create user', 0, $e);
        }
    }

    public function updateUser(int $id, array $data): void
    {
        try {
            $this->apiCall(
                'PUT',
                "/users/$id",
                [
                    'json' => ArrayHelper::keysToSnakeCase($data),
                ]
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to update user', 0, $e);
        }
    }

    public function deleteUser(int $id): void
    {
        try {
            $this->apiCall(
                'DELETE',
                "/users/$id"
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to delete user', 0, $e);
        }
    }

    public function fetchUser(int $id): User
    {
        try {
            $response = $this->apiCall(
                'GET',
                "/users/$id"
            );
            $result = $this->parseResponse($response)['data']['result'];
            return User::fromArray($result);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch user', 0, $e);
        }
    }

    private function apiCall(string $method, string $endpoint, array $options = []): ResponseInterface
    {
        return $this->client->request(
            $method,
            'http://' . $this->apiHost . ':' . $this->apiPort . $endpoint,
            array_merge(
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiToken,
                    ],
                ],
                $options
            )
        );
    }

    private function parseResponse(ResponseInterface $response): array
    {
        try {
            $body = $response->getContent();
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON');
            }

            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException('Parsing failure', 0, $e);
        }
    }
}
