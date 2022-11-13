<?php

namespace core\base\models;

use core\base\controllers\SingleTon;

class Crypt
{

    use SingleTon;

    private $cryptMethod = 'AES-256-CBC';
    private $hashAlgoritm = 'sha256';
    private $hashLength = 32;

    public function encrypt($str) {

        $ivlen = openssl_cipher_iv_length($this->cryptMethod);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($str, $this->cryptMethod, CRYPT_KEY, OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac($this->hashAlgoritm, $ciphertext_raw, CRYPT_KEY, true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

        return $ciphertext;

    }

    public function decrypt($str) {

        $str = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($this->cryptMethod);
        $iv = substr($str, 0, $ivlen);
        $hmac = substr($str, $ivlen, $this->hashLength);
        $ciphertext_raw = substr($str, $ivlen+$this->hashLength);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $this->cryptMethod, CRYPT_KEY, OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac($this->hashAlgoritm, $ciphertext_raw, CRYPT_KEY, true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        } else {
            return false;
        }

    }

}