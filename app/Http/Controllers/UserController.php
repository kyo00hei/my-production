<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * user一覧
     */
    public function index(Request $request){

        $users = User::all();

        return view('user.index',compact(['users']));
    }

    /**
    * 権限付与機能
     */
    public function update(Request $request){

        $user = user::find($request->id);
        $user->role = $request->role;
        $user->save();

        return back()->withInput();
    }

    /**
     * user削除機能
     */
    public function destroy(Request $request){

        $user = User::find($request->id);
        $user->delete();

        return redirect('/users');
    }
}
