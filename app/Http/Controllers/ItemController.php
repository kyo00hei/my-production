<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->paginate(5);  //ページネーション

        //検索機能
        if(!empty($request->keyword)){  //keywordがあるとき
            $items = Item::query()
            ->where('name','LIKE',"%{$request->keyword}%")
            ->orWhere('detail','LIKE',"%{$request->keyword}%")
            ->orWhere('type','LIKE',"%{$request->keyword}%")
            ->paginate(5);
        }

        return view('item.index', compact('items'));
    }


    /**
     * my商品一覧
     */
    public function mylist(Request $request){
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

        return view('item.mylist', compact('items'));
    }

    /**
     * 在庫一覧
     */
    public function inventory(Request $request)
    {
        // 在庫商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->paginate(20);  //ページネーション

        //検索機能
        if(!empty($request->keyword)){  //keywordがあるとき
            $items = Item::query()
            ->where('name','LIKE',"%{$request->keyword}%")
            ->orWhere('detail','LIKE',"%{$request->keyword}%")
            ->orWhere('type','LIKE',"%{$request->keyword}%")
            ->paginate(20);
        }

        return view('item.inventory', compact('items'));

       
    }

        /**
         * 在庫数変更機能
         */
        public function inventory_update(Request $request){

            $item = Item::find($request->id);
            $item->inventory = $request->inventory;
            $item->save();

            $items = Item
            ::where('items.status', 'active')
            ->select()
            ->paginate(20);

            return view('item.inventory', compact('items'));
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
        $item->delete();

        return redirect('/items');
    }

    
}
