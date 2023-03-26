<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable; // ソート条件でのpaginate反映の追加

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'detail',
        'inventory', //入庫、売り上げのデータを取ってきて入れるカラム
    ];
    
    /**
     * ソート条件をpaginate反映の追加
     */
    use Sortable;
    public $sortable = ['id', 'name', 'type', 'detail','inventory']; //表示させるカラム



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
