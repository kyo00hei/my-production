@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>user一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">一覧</h3>
                    <div class="card-tools">

                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>email</th>
                                <th>権限</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('user.update', $user->id) }}" class="user pl-5">
                                            @method('put')
                                            @csrf
                                            <input type="number" class="row-g3 w-25" name="role" placeholder="role" value="{{ $user->role}}">
                                            <button type="submit" class="btn btn-outline-info btn-sm">変更</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.destroy' ,$user->id) }}" method="POST">
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

    </div>
@stop

@section('css')
@stop

@section('js')
@stop
