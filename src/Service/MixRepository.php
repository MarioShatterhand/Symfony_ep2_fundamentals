<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface $cache
    )
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findAll(): array
    {
        return $this->cache->get('mixed_data', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            $response = $this->httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
            return $response->toArray();
        });
    }

}