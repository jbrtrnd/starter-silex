<?php

namespace User\Security\Token;

use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;

/**
 * JWT Token service.
 *
 * Manages Json Web Tokens.
 *
 * @package User\Security\Token
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class Service
{
    /**
     * @var string The secret pass phrase to sign the token.
     */
    protected $secret;

    /**
     * @var string The algorithm used to encrypt the token ('HS256', 'HS384', 'HS512' and 'RS256').
     */
    protected $algorithm;

    /**
     * @var int The expiration time in seconds.
     */
    protected $expiration;

    /**
     * Service constructor.
     *
     * @param string $secret     The secret pass phrase to sign the token.
     * @param string $algorithm  The algorithm used to encrypt the token ('HS256', 'HS384', 'HS512' and 'RS256').
     * @param int    $expiration The expiration time in seconds.
     */
    public function __construct(string $secret, string $algorithm, int $expiration)
    {
        $this->secret     = $secret;
        $this->algorithm  = $algorithm;
        $this->expiration = $expiration;
    }

    /**
     * Generate a JWT.
     *
     * @param array $data More data to store in the token.
     *
     * @return string The generated token.
     */
    public function generate(array $data = []): string
    {
        $now = time();

        $payload = array_merge($data, [
            'exp'  => $now + $this->expiration,
            'iat'  => $now
        ]);

        return JWT::encode($payload, $this->secret, $this->algorithm);
    }

    /**
     * Decode a token.
     *
     * @param string $token The token to decode.
     *
     * @return array The decoded token.
     */
    public function decode(string $token): array
    {
        return (array) JWT::decode($token, $this->secret, [$this->algorithm]);
    }

    /**
     * Retrieve a token from an HTTP request.
     *
     * @param Request $request An HTTP request.
     *
     * @return mixed|null The retrieved token (if present).
     */
    public function retrieve(Request $request): ?string
    {
        $token         = null;
        $authorization = $request->headers->get('Authorization', false);
        if ($authorization) {
            $token = str_replace('Bearer : ', '', $authorization);
        }

        return $token;
    }
}
