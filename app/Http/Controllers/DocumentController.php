<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\ValidateDocumentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function getDocuments(Request $request)
    {
        return Document::where('user_id', $request->user()->id)->get();
    }

    public function storeDocument(ValidateDocumentRequest $request)
    {
        $request->validated();
        $nameDocumentUploaded = $request->file('document')->store('documents', 'public');
        $data = $request->except(['document']);

        $dateFormat = Carbon::parse($data['date_published'])->format('Y-m-d');

        $data['url_file'] = $nameDocumentUploaded;
        $data['date_published'] = $dateFormat;
        $data['user_id'] = $request->user()->id;

        $newDocument = new Document($data);
        $newDocument->save();
        return response()->json($newDocument);
    }

    public function updateDocument(ValidateDocumentRequest $request)
    {
        $request->validated();
        $document = Document::findOrFail($request->id);
        $dataUpdated = $request->except(['document']);

        if ($request->hasFile('document')) {
            if (Storage::disk('public')->delete($document->url_file)) {
                $nameDocumentUploaded = $request->file('document')->store('documents', 'public');
                $dataUpdated['url_file'] = $nameDocumentUploaded;
            }
        }
        $dateFormat = Carbon::parse($dataUpdated['date_published'])->format('Y-m-d');
        $dataUpdated['date_published'] = $dateFormat;
        $document->fill($dataUpdated);
        $document->save();
        return $document;
    }
}
