<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocumentFilterController extends Controller
{
    public function filter(Request $request)
    {
        $query = Document::query();

        $filter = $request->filter;

        $query->orWhere('title', 'like', '%' . $filter . '%');
        $query->orWhere('keywords', 'like', '%' . $filter . '%');
        $query->orWhere('authors', 'like', '%' . $filter . '%');
        $query->orWhere('summary', 'like', '%' . $filter . '%');

        $results = $query->get();

        if ($results->count() > 0) {
            return $query->get();
        }

        return response()->json([], 404);
    }
}
