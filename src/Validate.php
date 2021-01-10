<?php


namespace Validation;

use Illuminate\Support\Str;

class Validate
{
    public function make($validator, $data, $scene)
    {
        if (!class_exists($validator)) {
            throw new \Validation\Exceptions\ValidatorException();
        }
        /** @var ValidatorInterface $validate */
        $validate = new $validator;

        $validator = \Illuminate\Support\Facades\Validator::make($data, $validate->scenes($scene), $validate->messages(), $validate->attributes());
        if ($validator->fails()) {
            throw new \Validation\Exceptions\ValidatorException($validator->errors()->first());
        }
    }
}
