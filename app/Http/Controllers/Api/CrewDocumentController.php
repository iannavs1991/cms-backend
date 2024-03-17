<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCrewDocumentRequest;
use Illuminate\Support\Facades\DB;
use App\Models\CrewDocument;
use Illuminate\Support\Facades\Storage;

class CrewDocumentController extends Controller
{
    /**
     * Get list of crew documents
     *
     * @param  mixed $request
     * @return void
     */
    protected function index(Request $request)
    {
        $size = $request->size ?: 10;
        $sort = $request->sort ?: 'id'; // default sort by id (ascending)

        try {
            $data = CrewDocument::with('crew', 'document', 'user')->where('crew_id', $request->crew_id)->orderBy($sort, 'Asc')->paginate($size);
        return response(['data' =>  $data], 200);
        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }
    }

     /**
     * Add Crew
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CreateCrewDocumentRequest $request)
    {
        $fileKey = key($request->file()) ? key($request->file()) : 'file';
        $validatedData = $request->validated();
        $input = $request->file($fileKey);
        $file = is_array($input) ? $input[0] : $input;

        DB::beginTransaction();

        try {
            $path =Storage::putFile('documents', $request->file('file'));
            $validatedData['uploaded_by'] = auth()->user()->id;
            $crew = CrewDocument::create($validatedData);

            DB::commit();

            return response(['data' =>  $crew, 'message' => 'New Document was successfully added.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show crew document by id
     *
     * @param  mixed $crew
     * @return void
     */
    protected function show(CrewDocument $crew_document)
    {
        try {
            return response(['data' => $crew_document, 'document_data' => $crew_document->document], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }

    }

    /**
     * Delete Crew document
     *
     * @param  mixed $request
     * @param  mixed $crew
     * @return void
     */
    protected function delete(CrewDocument $crew_document)
    {
        DB::beginTransaction();

        try {
            $crew_document->delete();

            DB::commit();

            return response(['data' =>  $crew_document, 'message' => 'Crewcument Do was successfully deleted.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }
}
