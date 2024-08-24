<?php

declare(strict_types=1);

namespace App\Services;

use Dotenv\Dotenv;

class HashService
{
    private const CIPHER_ALGO = 'aes-256-cbc';

    private string $secretKey;
    private string $iv;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(BASE_PATH);
        $dotenv->load();

        $this->secretKey = $_ENV['SECRET_KEY'];
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::CIPHER_ALGO));
    }

    /**
     * @param string $dateToEncode
     * @return string
     */
    public function encrypt(string $dateToEncode): string
    {
        $encryptedData = openssl_encrypt($dateToEncode, self::CIPHER_ALGO, $this->secretKey, 0, $this->iv);

        return base64_encode($encryptedData . '::' . $this->iv);
    }

    /**
     * @param string $encryptedData
     * @return string
     */
    public function decrypt(string $encryptedData): string
    {
        [$encryptedData, $iv] = explode('::', base64_decode($encryptedData), 2);

        return openssl_decrypt($encryptedData, self::CIPHER_ALGO, $this->secretKey, 0, $iv);
    }
}
