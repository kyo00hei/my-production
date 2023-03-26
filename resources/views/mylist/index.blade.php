@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>My登録一覧</h1>
    <h3>ID:{{Auth::user()->id}}/{{Auth::user()->name}}</h3>

    <!--検索フォーム-->
    <div class="search text-right mb-3">
        <form action="">
            <input type="text" name="keyword"  placeholder="商品検索">
            <button type="submit" class="btn btn-dark">検索</button>
        </form>
    </div>

    <!--並び替え-->
    <div class="sort-tag text-right">
        @sortablelink('id','ID')/@sortablelink('name','名前')/@sortablelink('type','種類')/@sortablelink('detail','詳細')
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>種別</th>
                                <th>詳細</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->detail }}</td>
                                    <td>
                                        <a href="{{ route('edit',$item->id)}}" class="btn btn-primary" >編集</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('destroy' ,$item->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container-fluid text-center col-md-2 col-md-offset-5">
        {{ $items->appends(request()->query())->links() }}
        </div>

    </div>
@stop

@section('css')
@stop

@section('js')
@stop
