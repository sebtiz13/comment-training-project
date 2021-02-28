<?php

declare(strict_types=1);

namespace App\Mercure;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Symfony\Component\HttpFoundation\Cookie;

class CookieGenerator
{
    public function __construct(
        private string $secret
    ) {
    }

    public function generate(): Cookie
    {
        $configuration = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($this->secret));

        $token = $configuration
            ->builder()
            ->withClaim('mercure', ['subscribe' => ['*']])
            ->getToken($configuration->signer(), $configuration->signingKey())
            ->toString();

        return Cookie::create('mercureAuthorization', $token, 0, '/.well-known/mercure');
    }
}
