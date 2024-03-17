<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Get list of crew
     *
     * @param  mixed $request
     * @return void
     */
    protected function index(Request $request)
    {
        $size = $request->size ?: 10;
        $sort = $request->sort ?: 'id'; // default sort by id (ascending)

        try {
            $data = Document::orderBy($sort, 'Asc')->paginate($size);

        return response(['data' =>  $data], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Add Document
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CreateDocumentRequest $request)
    {
        #Validate
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $crew = Document::create($validatedData);

            DB::commit();

            return response(['data' =>  $crew, 'message' => 'New Document was successfully added.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Update Document
     *
     * @param  mixed $request
     * @param  mixed $document
     * @return void
     */
    protected function update(UpdateDocumentRequest $request, Document $document)
    {
        #Validate
        $param = $request->validated();

        DB::beginTransaction();

        try {
            $document->update($param);

            DB::commit();

            return response(['data' =>  $document, 'message' => 'Document was successfully updated.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Delete Document
     *
     * @param  mixed $request
     * @param  mixed $document
     * @return void
     */
    protected function delete(Document $document)
    {
        DB::beginTransaction();

        try {
            $document->delete();

            DB::commit();

            return response(['data' =>  $document, 'message' => 'Document was successfully deleted.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show document by id
     *
     * @param  mixed $crew
     * @return void
     */
    protected function show(Document $document)
    {
        try {

            return response(['data' => $document], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }

    }
}
