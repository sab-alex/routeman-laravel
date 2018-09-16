<?php

namespace App\Http\Controllers;
use App\Services\ArticleService;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->service = new ArticleService();
    }

    public function get(Request $request)
    {
        return $this->service->get($request->all());
    }
}
