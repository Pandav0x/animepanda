<?php


namespace App\Service;

class Encoder
{

    /**
     * @param string $string
     * @return string
     * @throws \Exception
     */
    public function encodeString(string $string): string
    {
        return password_hash($string, PASSWORD_BCRYPT, [
            'cost' => random_int(10, 14),
        ]);
    }
}