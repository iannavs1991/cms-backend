<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Get list of roles
     *
     * @param  mixed $request
     * @return void
     */
    protected function index(Request $request)
    {
        try {
            $data = Role::get();

        return response(['data' =>  $data], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Add Role
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CreateRoleRequest $request)
    {
        #Validate
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $role = Role::create($validatedData);

            DB::commit();

            return response(['data' =>  $role, 'message' => 'New User Role was successfully added.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show role by id
     *
     * @param  mixed $crew
     * @return void
     */
    protected function show(Role $role)
    {
        try {

            return response(['data' => $role], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }

    }

    /**
     * Update Role
     *
     * @param  mixed $request
     * @param  mixed $rank
     * @return void
     */
    protected function update(UpdateRoleRequest $request, Role $role)
    {
        #Validate
        $param = $request->validated();

        DB::beginTransaction();

        try {
            $role->update($param);

            DB::commit();

            return response(['data' =>  $role, 'message' => 'User Role was successfully updated.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Delete Role
     *
     * @param  mixed $request
     * @param  mixed $role
     * @return void
     */
    protected function delete(Role $role)
    {
        DB::beginTransaction();

        try {
            $role->delete();

            DB::commit();

            return response(['data' =>  $role, 'message' => 'User Role was successfully deleted.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }
}
