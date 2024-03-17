<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCrewRequest;
use App\Http\Requests\UpdateCrewRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Crew;

class CrewController extends Controller
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

            $data = Crew::with('rank')
            ->when(!empty($request->rank_filter), function ($q) use ($request) {
                $q->where('rank', $request->rank_filter);

            })
            ->when(!empty($request->keyword), function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('first_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'like', "%". $request->keyword. "%");
                });

            })->paginate($size);

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
    public function store(CreateCrewRequest $request)
    {
        #Validate
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $crew = Crew::create($validatedData);

            DB::commit();

            return response(['data' =>  $crew, 'message' => 'New Crew was successfully added.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();
            return response(['message' => $e->getMessage()], 400);
        }
    }

     /**
     * Update Crew
     *
     * @param  mixed $request
     * @param  mixed $crew
     * @return void
     */
    protected function update(UpdateCrewRequest $request, Crew $crew)
    {
        #Validate
        $param = $request->validated();

        DB::beginTransaction();

        try {
            $crew->update($param);

            DB::commit();

            return response(['data' =>  $crew, 'message' => 'Crew was successfully updated.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Delete Crew
     *
     * @param  mixed $request
     * @param  mixed $crew
     * @return void
     */
    protected function delete(Crew $crew)
    {
        DB::beginTransaction();

        try {
            $crew->delete();

            DB::commit();

            return response(['data' =>  $crew, 'message' => 'Crew was successfully deleted.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show crew by id
     *
     * @param  mixed $crew
     * @return void
     */
    protected function show(Crew $crew)
    {
        try {

            return response(['data' => $crew], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }

    }
}
