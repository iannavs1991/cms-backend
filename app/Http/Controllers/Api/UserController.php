<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get list of users
     *
     * @param  mixed $request
     * @return void
     */
    protected function index(Request $request)
    {
        $size = $request->size ?: 10;
        $sort = $request->sort ?: 'id'; // default sort by id (ascending)

        try {
            $data = User::orderBy($sort, 'Asc')->paginate($size);

        return response(['data' =>  $data], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Add User
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CreateUserRequest $request)
    {
        #Validate
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);

            DB::commit();

            return response(['data' =>  $user, 'message' => 'New User was successfully added.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show user by id
     *
     * @param  mixed $user
     * @return void
     */
    protected function show(User $user)
    {
        try {

            return response(['data' => $user], 200);

        } catch (\Exception $e) {
            #error message
            return response(['message' => $e->getMessage()], 400);
        }

    }

    /**
     * Update user
     *
     * @param  mixed $request
     * @param  mixed $user
     * @return void
     */
    protected function update(UpdateUserRequest $request, User $user)
    {
        #Validate
        $param = $request->validated();

        DB::beginTransaction();

        try {
            $user->update($param);

            DB::commit();

            return response(['data' =>  $user, 'message' => 'User was successfully updated.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Delete User
     *
     * @param  mixed $request
     * @param  mixed $user
     * @return void
     */
    protected function delete(User $user)
    {
        DB::beginTransaction();

        try {
            $user->delete();

            DB::commit();

            return response(['data' =>  $user, 'message' => 'User was successfully deleted.'], 200);
        } catch (\Exception $e) {
            //Rollback Changes
            DB::rollback();

            return response(['message' => $e->getMessage()], 400);
        }
    }
}
