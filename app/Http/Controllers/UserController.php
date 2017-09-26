<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class UserController extends Controller
{

    use SendsPasswordResetEmails;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-users');

        $users = User::where('department', auth()->guard('web')->user()->department)->orderBy('first_name', 'ASC')->orderBy('last_name', 'ASC')->get();
        $roles = Role::all()->pluck('label', 'name');
        return view('admin.user.index', compact('users', 'roles'));
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
        $this->authorize('create-users');

        $user = new User();
        $user->fill($request->all());
        $user->password = str_random(64);
        if(!$request->has('department')){
            $user->department = auth()->guard('web')->user()->department;
        }
        $user->save();

        $user->assignRole($request->get('role'));

        //$token = app('auth.password.broker')->createToken($user);
        //$user->sendPasswordResetNotification($token);
        $this->sendResetLinkEmail($request);

        return redirect()->back()->with('success', "A new user account has been created for $user->first_name $user->last_name");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $this->authorize('edit-users');

        $user = User::find($id);
        $roles = Role::all()->pluck('label', 'name');
        $departments = Department::all()->pluck('name','id')->all();
        return view('admin.user.edit', compact('user', 'departments', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit-users');

        $user = User::find($id);
        $user->fill($request->all());
        $user->save();

        $user->assignRole($request->get('role'));

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-users');

        $user = User::findorFail($id);
        $user->delete();

        return redirect()->back();
    }
}
