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
        $items = $request->user()->items();

    
        /**検索機能 */
        if(!empty($request->keyword)){  //keywordがあるとき
            $user_id = Auth::id();

            $keyword = $request->keyword;

            //全角数字→半角数字
            $keyword_half = mb_convert_kana($keyword, 'n');

            //キーワードがtypeの種類だった場合に数値に変えている
            foreach(config('type') as $type_value => $type){
                if($request->keyword == $type){
                    $keyword = $type_value;
                }
            }
                
            //キーワードが数値(全角数字は半角数字に変換済み)の時はtypeカラムを検索対象から外す
            if(is_numeric($keyword_half)){
                $items =Item::where('user_id', '=' ,"$user_id")
                        ->where(function($query) use($keyword) {
                                $query->where('id','LIKE',"%{$keyword}%")
                                ->orWhere('name','LIKE',"%{$keyword}%")
                                ->orWhere('detail','LIKE',"%{$keyword}%");
                                });

            //キーワードが数値以外(全角数字)のときはtypeカラムを検索対象に含む
            }else{
                $items =Item::where('user_id', '=' ,"$user_id")
                        ->where(function($query) use($keyword) {
                                $query->where('name','LIKE',"%{$keyword}%")
                                ->orWhere('detail','LIKE',"%{$keyword}%")
                                ->orWhere('type','LIKE',"%{$keyword}%");
                                });
            }    
        }
        $items = $items->sortable()->paginate(5);
        return view('mylist.index', compact('items'));
    }
}
