<?php


namespace Validation;


interface ValidatorInterface
{
    public function rules();

    public function scenes($scene);

    public function messages();

    public function attributes();
}
