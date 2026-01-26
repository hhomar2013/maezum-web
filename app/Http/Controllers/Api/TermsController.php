<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Term;



class TermsController extends Controller
{
    use ApiResponseTrait;
    public $terms;
    public function index()
    {
        $term = Term::query()->get();
        if ($term) {
            $this->terms = $term->map(function ($e) {
                return [
                    'id' => $e->id,
                    'title' => $e->title,
                    'content' => $e->content,
                ];
            });
            return $this->apiRsponse($this->terms, 'terms', 200);
        }
    }
}
