<?php

declare(strict_types=1);

namespace App\Mercure;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class JWTProvider
{
    public function __construct(
        private string $secret
    ) {
    }

    public function __invoke(): string
    {
        $configuration = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($this->secret));

        return $configuration
            ->builder()
            ->withClaim('mercure', ['publish' => ['*']])
            ->getToken($configuration->signer(), $configuration->signingKey())
            ->toString();
    }
}
