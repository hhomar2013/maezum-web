<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class faqsController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $faqs = Faq::query()->limit(2)->get();
        $data = [];
        foreach ($faqs as $faq) {
            $data[] = [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
            ];
        }

        return response()->json([
            'status' => 'success',
            'message' => __('Data received'),
            'data' => $data
        ], 200);
    }


    public function showAll()
    {
        $faqs = Faq::query()->get();
        $data = [];
        foreach ($faqs as $faq) {
            $data[] = [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
            ];
        }

        return response()->json([
            'status' => 'success',
            'message' => __('Data received'),
            'data' => $data
        ], 200);
    }
}
