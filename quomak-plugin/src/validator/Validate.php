<?php

namespace Plugin\Validator;


use Rakit\Validation\Validator as RakitValidator;
use Plugin\Validator\UniqueRule;
use Plugin\Validator\BlacklistedRule;
use Plugin\Validator\ExistsRule;
use Plugin\Validator\NonceRule;


class Validate{

    private $validator;

    public function __construct(){

        $this->validator = new RakitValidator;
        $this->validator->addValidator('unique', new UniqueRule());
        $this->validator->addValidator('blacklisted', new BlacklistedRule());
        $this->validator->addValidator('exists', new ExistsRule());
        $this->validator->addValidator('nonce', new NonceRule());

    }

    public function validate($fields, $rules, $messages=array()){
        

        $validation = $this->validator->make($fields, $rules, $messages);

        $validation->validate();

        $errors = $validation->errors();

        return $errors->all();
       
    }
}