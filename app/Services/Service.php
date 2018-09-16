<?php
namespace App\Services;



class Service
{
    public $search_params;
    public $allowed_params=[
        'order_sort'=>[
            'desc',
            'asc'
        ]
    ];
    protected function setParams($params=null){
        if($params){
            foreach ($params as $key=>$value) {
                if(isset($this->search_params[$key])){
                    if(isset($this->allowed_params[$key])){
                        if(in_array($value,$this->allowed_params[$key])){
                            $this->search_params[$key]=$value;
                        }
                    }else{
                       $this->search_params[$key]=$value;
                    }
                }
            }
        }
    }
    protected function _setParams($params=null){
        if($params){
            foreach ($params as $key=>$value) {
                if(isset($this->search_params[$key])){
                    $this->search_params[$key]=$value;
                }
            }
        }
    }
    public function getParams($params=null){
        $this->setParams($params);
        return  $this->search_params;
    }




    //FILTERS APPLY
    public static function applyFilter($query, $className, $filterName){
        $decorator = static::createFilterDecorator($className, $filterName);
        if (static::isValidDecorator($decorator)) {
            $query = $decorator::apply($query, null);
        }
        return $query;
    }
    public static function applyFilters($query, $className, $filters){
        foreach($filters as $filter){
            $query=self::applyFilter($query, $className, $filter);
        }
        return $query;
    }
    public static function applyFiltersFromRequest(Request $filters ,$query, $className){
        return static::applyDecoratorsFromRequest($filters, $query, $className);
    }
    private static function applyDecoratorsFromRequest(Request $request, Builder $query, $className)
    {
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($className, $filterName);
            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }
        return $query;
    }
    private static function createFilterDecorator($className, $name){
        return 'App\\Filters\\' .$className .'\\'. studly_case($name);
    }
    private static function isValidDecorator($decorator){
        return class_exists($decorator);
    }

    public static function ValidationException($errors){
        return new ValidationException($errors);
    }
    public static function ModelNotFoundException(){
        return new NotFoundException();
    }
    public static function Exception($error){
        return new \App\Exceptions\AppException($error);
    }
    public static function PermissionException($error = null){
        return new \App\Exceptions\PermissionException($error);
    }
    public static function ImageValidationException($errors){
        return new \App\Exceptions\ImageValidationException($errors);
    }
    public static function VideoValidationException($errors){
        return new \App\Exceptions\VideoValidationException($errors);
    }
    public static function AudioValidationException($errors){
        return new \App\Exceptions\AudioValidationException($errors);
    }
    public static function AppException($errors){
        return new \App\Exceptions\AppException($errors);
    }
    public static function BlackListException($errors){
        return new \App\Exceptions\BlackListException($errors);
    }
}