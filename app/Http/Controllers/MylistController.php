<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Item;

class MylistController extends Controller
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
     * my商品一覧
     */
    public function index(Request $request){
        //userが保持するitemsを取得
        $items = $request->user()->items()->paginate(5);

        if(!empty($request->keyword)){  //keywordがあるとき
            $user_id = Auth::id();
            $items =Item::where('user_id', '=' ,"$user_id")
                    ->where(function($query) use($request) {
                    $query->where('name','LIKE',"%{$request->keyword}%")
                    ->orWhere('detail','LIKE',"%{$request->keyword}%")
                    ->orWhere('type','LIKE',"%{$request->keyword}%");
            })
            ->paginate(5);
        }

        return view('mylist.index', compact('items'));
    }
}
