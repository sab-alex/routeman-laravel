<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Services\CommentsService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->service = new CommentsService();
    }

    /**
     * @param Request $request
     * @param $model
     * @param $id
     * @return mixed
     */
    public function get(Request $request, $model, $id)
    {
        $params = $request->all();
        $params['model'] = $model;
        $params['id'] = $id;
        return $this->service->get($request->all());
    }
}
