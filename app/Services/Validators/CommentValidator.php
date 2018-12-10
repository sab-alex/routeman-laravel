<?php
namespace App\Services\Validators;

class CommentValidator extends Validator
{
    private $availableModels = [
        'article' => 'App\Article'
    ];

    public function getRules()
    {
        return[
          'model' => 'required|in:'.implode(',', array_keys($this->availableModels)),
          'id' =>'required|integer',
          'skip' => 'integer',
          'limit' => 'integer|max:100',
          'search' => 'max:255',
          'order_by' => 'sometimes|in:date',
          'order_sort' => 'sometimes|in:desc,asc'
       ];
    }
    public $getRulesId=[
        'article_id'=>'required|integer',
    ];
    public $orderColumns=[
        'date'=>'articles.created_at'
    ];
    public $getDefaults=[
        'skip' => 0,
        'limit' => 10,
        'order_by' => 'date',
        'order_sort' => 'desc',
    ];

    public function storeRules()
    {
        return [

        ];
    }
    public function updateRules()
    {
        return [

        ];
    }

    public function isValidForGet($input)
    {
        return $this->validate($input, $this->getRules());
    }
    public function setGetParams($input)
    {
        return $this->setParams($input, $this->getRules, $this->getDefaults);
    }
}