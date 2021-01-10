<?php

namespace Validation;

use App\Exceptions\ValidatorSceneNotFoundExException;
use Illuminate\Support\Str;

abstract class Validator implements ValidatorInterface
{
    public $scenes = [];

    abstract public function messages();

    abstract public function rules();

    abstract public function attributes();

    /**
     * @param $scene
     * @return array
     * @throws ValidatorSceneNotFoundExException
     */
    final public function scenes($scene)
    {
        $ret_rule = [];
        if (array_key_exists($scene, $this->scenes)) {
            $scene_rules = $this->scenes[$scene];
            foreach ($scene_rules as $scene_rule) {
                foreach ($this->rules() as $key => $rule) {
                    if ($scene_rule === $key) {
                        $ret_rule[$key] = $rule;
                    }
                }
            }
            return $ret_rule;
        } else {
            $scene_name = 'scene' . Str::studly($scene);
            if (!method_exists($this, $scene_name)) {
                throw new ValidatorSceneNotFoundExException();
            }
            $ret_rule = $this->$scene_name();
            return $ret_rule;
        }

    }

    final public function only($rules)
    {
        foreach ($rules as $scene_rule) {
            foreach ($this->rules() as $key => $rule) {
                if ($scene_rule === $key) {
                    $ret_rule[$key] = $rule;
                }
            }
        }
        return $ret_rule;
    }
}
