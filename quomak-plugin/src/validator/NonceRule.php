<?php
namespace Plugin\Validator;

use Rakit\Validation\Rule;
use Plugin\Core\Log;

class NonceRule extends Rule{


    protected $message = "The :attribute is invalid";

    protected $fillableParams = ['nonce'];

    public function check($value): bool
    {

        $key = !empty($this->parameter('nonce'))? $this->parameter('nonce') : $_ENV['NONCE_SECRET'];


        file_put_contents(__DIR__.'/./key.txt', $key);

        file_put_contents(__DIR__.'/./nonce.txt', $value);

        return wp_verify_nonce($value, $key);

    }

}