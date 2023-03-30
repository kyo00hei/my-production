<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Item;

use App\Models\Log;

class InventoryController extends Controller
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
     * 在庫一覧
     * inventoryは入庫、売上での演算した数値が入る
     * 
     */
    public function index(Request $request)
    {
        // 在庫商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select();

         //検索機能
         if(!empty($request->keyword)){  //keywordがあるとき
            $items = Item::query()
            ->where('name','LIKE',"%{$request->keyword}%")
            ->orWhere('detail','LIKE',"%{$request->keyword}%")
            ->orWhere('type','LIKE',"%{$request->keyword}%");

        } 

        $items = $items->sortable()->paginate(20);

        return view('inventory.index', compact('items'));

    }

        /**
         * 在庫数変更機能
         */
        public function update(Request $request){

            $item = Item::find($request->id);
            $item->inventory = $request->inventory;
            $item->save();

             //log機能(商品在庫)
            Log::create([
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'item_name' => $item->name,
                'action' => '4',
                'description'=> (Auth::user()->name).'さんが商品：'.($item->name).'の在庫数を更新しました'
            ]);

            return back()->withInput();

        }

}
