<?php
namespace App\Services\Validators;

class ArticleValidator extends Validator
{
    public $mediaObjects = [
        'photos'
    ];
    public $getRules=[
      'skip'=>'integer',
      'limit'=>'integer|max:100',
      'user_id'=>'integer',
      'search'=>'max:255',
      'order_by'=>'sometimes|in:date',
      'order_sort'=>'sometimes|in:desc,asc'
    ];
    public $getRulesId=[
        'article_id'=>'required|integer',
    ];
    public $orderColumns=[
        'date'=>'articles.created_at'
    ];
    public $getDefaults=[
        'skip'=>0,
        'limit'=>10,
        'order_by'=>'date',
        'order_sort'=>'desc',
    ];

    public function storeRules()
    {
        return [
            'title' => 'min:3|max:10000',
            'description' => 'max:10000',
            'is_anonym' => 'required|boolean',
            'photos' => 'array|max:'.config('app.article.MAX_COUNT_PHOTOS')
        ];
    }
    public function updateRules()
    {
        return [

        ];
    }

    public function isValidForGet($input)
    {
        return $this->validate($input, $this->getRules);
    }
    public function setGetParams($input)
    {
        return $this->setParams($input, $this->getRules, $this->getDefaults);
    }
}