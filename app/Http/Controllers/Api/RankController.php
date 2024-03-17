<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rank;
use App\Http\Requests\CreateRankRequest;
use App\Http\Requests\UpdateRankRequest;
use Illuminate\Support\Facades\DB;

class RankController extends Controller
{
     /**
     * Get list of ranks
     *
     * @param  mixed $request
     * @return void
     */
    protected function index(Request $request)
    {
        $size = $request->size ?: 10;
        $sort = $request->sort ?: 'id'; // default sort by id (ascending)

        try {
            $data = Rank::orderBy($sort, 'Asc')->paginate($size);

        return response(['data' =>  $data], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Add Rank
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CreateRankRequest $request)
    {
        #Validate
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $rank = Rank::create($validatedData);

            DB::commit();

            return response(['data' =>  $rank, 'message' => 'New Rank was successfully added.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show rank by id
     *
     * @param  mixed $crew
     * @return void
     */
    protected function show(Rank $rank)
    {
        try {

            return response(['data' => $rank], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }

    }

    /**
     * Update Rank
     *
     * @param  mixed $request
     * @param  mixed $rank
     * @return void
     */
    protected function update(UpdateRankRequest $request, Rank $rank)
    {
        #Validate
        $param = $request->validated();

        DB::beginTransaction();

        try {
            $rank->update($param);

            DB::commit();

            return response(['data' =>  $rank, 'message' => 'Rank was successfully updated.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Delete Rank
     *
     * @param  mixed $request
     * @param  mixed $rank
     * @return void
     */
    protected function delete(Rank $rank)
    {
        DB::beginTransaction();

        try {
            $rank->delete();

            DB::commit();

            return response(['data' =>  $rank, 'message' => 'Rank was successfully deleted.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }
}
