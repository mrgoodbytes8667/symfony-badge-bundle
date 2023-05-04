<?php

namespace Bytes\SymfonyBadge\Services;

use Bytes\SymfonyBadge\Objects\Symfony;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Versions
{
    private HttpClientInterface $client;

    /**
     * @param HttpClientInterface $httpClient
     * @param SerializerInterface $serializer
     * @param string $cachePath
     */
    public function __construct(HttpClientInterface $httpClient, private SerializerInterface $serializer, string $cachePath)
    {
        $store = new Store($cachePath);
        $this->client = new CachingHttpClient($httpClient, $store, ['default_ttl' => 6 * 3600]);
    }

    /**
     * @return Symfony|null
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getNormalizedReleases(): ?Symfony
    {
        return $this->getReleases()?->normalize();
    }

    /**
     * @return Symfony|null
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getReleases(): ?Symfony
    {
        $response = $this->client->request('GET', 'https://symfony.com/releases.json');
        return $this->serializer->deserialize($response->getContent(), Symfony::class, 'json');
    }
}
