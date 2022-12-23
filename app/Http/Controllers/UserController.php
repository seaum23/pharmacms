<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|confirmed',
        ]);

        try{
            $user = $request->input();
            $user['password'] = bcrypt($user['password']);
            return new UserResource(User::create($user));
        }catch(Exception $e){
            if($e->getCode() == '23000'){
                return response(['errors' => 'Phone already exists!'], 500);
            }else{
                return response($e->getMessage(), 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // var_dump($user->phone);
        // exit();
        $request->validate([
            'phone' => 'required'
        ]);

        $user->name = $request->name;
        if($user->phone != $request->phone){
            $user->phone = $request->phone;
        }
        $user->email = $request->email;

        try{
            $user->save();
            return new UserResource($user);
        }catch(Exception $e){
            if($e->getCode() == '23000'){
                return response(['errors' => 'Phone already exists!'], 500);
            }else{
                return response($e->getMessage(), 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
