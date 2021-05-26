<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserController extends Controller
{
    public $keyword = '';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::latest()->with('roles');

        if (!empty($request->keyword)) {
            $this->keyword = $request->keyword;
            
            $users = $users->where('name','like',"%".$this->keyword."%");
            $users = $users->orWhere('email','like',"%".$this->keyword."%");

            $users = $users->orWhereHas('roles', function ($query) {
                $query->where('name', 'like', "%".$this->keyword."%");
            });
            
        }
        
        return view('users.index')->with('users', $users->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required'
        ]);

        $user = User::firstOrCreate([
            'email' => $request->email
        ], [
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'status' => true
        ]);

        $user->assignRole($request->role);

        session()->flash('success', "Data User : $user->name Berhasil Ditambahkan");

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
        $hasPegawaiOrSiswa = (!empty($user->siswa) || !empty($user->pegawai)) ? true : false;

        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.edit')
                ->with('roles', $roles)
                ->with('user', $user)
                ->with('hasPegawaiOrSiswa', $hasPegawaiOrSiswa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
        // return $request->all();
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100|min:4|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|nullable|confirmed|min:6',
        ]);


        $password = !empty($request->password) ? bcrypt($request->password) : $user->password;
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'status' => $request->status,
        ]);

        $user->syncRoles([$request->input('role')]);

        session()->flash('success', "Data User : $user->name Berhasil Diubah");

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->hasRole('admin')){
            session()->flash('error', "Data user $user->name dengan Role Admin Tidak Bisa dihapus!!");

            //redirect user
            return redirect(route('users.index'));
        }

        if($user->status == true){
            session()->flash('error', "Tidak Bisa Menghapus User Yang masih dalam status Aktif!!");
        }else{
            $user->delete();
    
            session()->flash('success', "Data User : $user->name Berhasil Dihapus");
        }

        return redirect(route('users.index'));
    }
}
