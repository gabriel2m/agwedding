<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing layout of the resource.
     */
    public function index(Request $request)
    {
        return view($request->header('X-HX-Page', false) ? 'admin.users.page' : 'admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserService $userService)
    {
        $userService->create($request->validated());

        return response(
            content: view('admin.users.index')->withAlert([
                'type' => 'success',
                'message' => trans_rep(':resource saved', ['resource' => 'User']),
            ]),
            headers: [
                'HX-Retarget' => '#content',
                'HX-Reswap' => 'outerHTML',
                'HX-Push-Url' => route('admin.users.index'),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        $userService->update($user, $request->validated());

        return response(
            content: view('admin.users.index')->withAlert([
                'type' => 'success',
                'message' => trans_rep(':resource saved', ['resource' => 'User']),
            ]),
            headers: [
                'HX-Retarget' => '#content',
                'HX-Reswap' => 'outerHTML',
                'HX-Push-Url' => route('admin.users.index'),
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return view('admin.alert', [
            'message' => trans_rep(':resource removed', ['resource' => 'User']),
            'type' => 'warning',
        ]);
    }
}
