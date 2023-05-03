<?php

namespace Bytes\SymfonyBadge\Services;

use Bytes\SymfonyBadge\Objects\Symfony;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Versions
{
    /**
     * @param HttpClientInterface $client
     * @param SerializerInterface $serializer
     */
    public function __construct(private HttpClientInterface $client, private SerializerInterface $serializer)
    {
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
