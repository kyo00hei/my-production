<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Log;


class ItemController extends Controller
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
     * 商品一覧
     */
    public function index(Request $request)
    {
        // 商品一覧取得
        $items = Item::where('items.status', 'active')
                ->select();

                //
                $keyword = 0;
        /**検索機能 */
        if(!empty($request->keyword)){  //keywordがあるとき
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
                $items = Item::query()
                        ->where('id','LIKE',"%{$keyword}%")
                        ->orWhere('name','LIKE',"%{$keyword}%")
                        ->orWhere('detail','LIKE',"%{$keyword}%");

            //キーワードが数値以外(全角数字)のときはtypeカラムを検索対象に含む
            }else{
                $items = Item::query()
                        ->where('name','LIKE',"%{$keyword}%")
                        ->orWhere('detail','LIKE',"%{$keyword}%")
                        ->orWhere('type','LIKE',"%{$keyword}%");
            }
        } 

        $items = $items->sortable()->paginate(5);   //ページネーション
        return view('item.index', compact('items','keyword'));//
    }


    
    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            //log機能(商品登録)
            Log::create([
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'item_name' => $request->name,
                'action' => '1',
                'description'=> (Auth::user()->name).'さんが商品：'.($request->name).'を登録しました'
            ]);


            return redirect('/items');
        }
        return view('item.add');
    }

    /**
     * 商品編集
     */
    public function edit(Request $request){

        $item = Item::where('id',$request->id)->first();

        //editへpostメソッドしたときに編集実行
        if ($request->isMethod('put')){
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            $item = Item::find($request->id);
            $item->name = $request->name;
            $item->type = $request->type;
            $item->detail = $request->detail;
            $item->save();

            //log機能(商品編集)
            Log::create([
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'item_name' => $request->name,
                'action' => '2',
                'description'=> (Auth::user()->name).'さんが商品：'.($request->name).'を編集しました'
            ]);

            return redirect('/items');
        }

            
        //商品編集画面へ
        return view('item.edit',['item'=>$item]);
    }

    /**
     * 商品削除機能
     */
    public function destroy(Request $request){

        $item = Item::find($request->id);

        //log機能(商品削除)
        Log::create([
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'item_name' => $item->name,
            'action' => '3',
            'description'=> (Auth::user()->name).'さんが商品：'.($item->name).'を削除しました'
        ]);

        
        $item->delete();

        

        return redirect('/items');
    }

    
}
