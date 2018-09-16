<?php
namespace App\Services\Validators;
use Validator as V;
use Illuminate\Support\MessageBag;
abstract class Validator
{

    protected $errors;
    public $orderColumns=[];
    public function validate($input, $rules, $messages=[])
    {
        $validator=V::make($input,$rules, $messages);
        if($validator->fails()){
            $this->errors=$validator->messages();
            return false;
        }
        return true;
    }
    public function extend($rule, $callback)
    {
        V::extend($rule,$callback);
    }
    public function errors()
    {
        return $this->errors;
    }

    protected function setParams($input, $rules, $defaults)
    {
        $output = [];
        foreach ($rules as $key => $value) {
            if (isset($input[$key])) {
                $output[$key] = $input[$key];
            } else if (isset($defaults[$key])) {
                $output[$key] = $defaults[$key];
            }
        }
        $output=$this->setOrderColumn($output);
        return $output;
    }
    public function setOrderColumn($input=[])
    {
        if(isset($input['order_by']) && isset($this->orderColumns[$input['order_by']]))
            $input['order_by']=$this->orderColumns[$input['order_by']];
        return $input;
    }

    public static function extendRules(Array $baseRules,  Array $newRules)
    {
       return  array_merge($baseRules, $newRules);
    }

    public static function filterData($input, $rules)
    {
        $output = [];
        foreach ($rules as $key => $value) {
            if (isset($input[$key])) {
                $output[$key] = $input[$key];
            }
        }
        return $output;
    }
}