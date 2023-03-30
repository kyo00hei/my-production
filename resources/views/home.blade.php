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
        
            @foreach ($logs as $log)
            <p><span class="text-secondary"> &nbsp {{ $log->created_at->diffForHumans() }}</span > &nbsp {{ $log->description }}</p>
            @endforeach
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

