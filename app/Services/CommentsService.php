<?php
namespace App\Services;

use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Services\Validators\ArticleValidator;



class CommentsService extends Service
{

    public function __construct()
    {
        $this->validator = new ArticleValidator();
    }

    /**
     * @param array $params
     * @return array
     * @throws ValidationException
     */
    public function get(array $params)
    {
        if(!$this->validator->isValidForGet($params)){
            throw self::ValidationException($this->validator->errors());
        }

        $searchParams = $this->validator->setGetParams($params);

        $query = (new Article)->newQuery();
        $query->with([
            'photos'
        ]);

        // TODO APPLY FILTERS


        $count=$query->count();
        $query->orderBy($searchParams['order_by'],$searchParams['order_sort']);
        $query->skip($searchParams['skip'])->take($searchParams['limit']);
        $data=$query->get();

        return ['data'=>$data, 'count'=>$count];
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function getById($id)
    {
        $params=[];
        $params['publication_id']=$id;
        if(!$this->validator->isValidForSearchId($params)){
            throw self::ValidationException($this->validator->errors());
        }
        $query=(new Publication)->newQuery();
        $query=$query->where('id', $params['publication_id']);
        $query=self::applyFilters($query,'Publication',$this->userAccessFilters);

        if(!$publication=$query->first())
            throw self::ModelNotFoundException();
        return $publication;
    }
}