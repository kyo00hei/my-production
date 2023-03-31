@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>

<!--履歴表示(登録/編集/削除/在庫)-->
    <h5 class="mt-5">History</h5>
    <div class="action-list text-info border border-dark overflow-auto" style="width:55%; height:200px; font-size:15px; background-color:#ffffff;">
<!--0又は20以上の時は利用権限無し履歴非表示-->
    @if( '0' == Auth::user()->role || '20' < Auth::user()->role)
        <h2 class="text-warning">閲覧権限がありません</h2>
<!--1から20までの時は利用権限あり履歴表示-->
    @else
        @foreach ($logs as $log)
            <p><span class="text-secondary"> &nbsp {{ $log->created_at->diffForHumans() }}</span > &nbsp {{ $log->description }}</p>
        @endforeach
    @endif
        </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

