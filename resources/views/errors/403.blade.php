
@extends('adminlte::page')

@section('title', 'ERROR')

@section('content_header')
    

@stop

@section('content')

<div class="w-100 text-center pt-5">
    <h1 class="text-danger mt-5 mb-5" >！！ERROR！！</h1>
    <h4 class="">{{Auth::user()->name}}さんはアクセス権限がありません</h4>
    <h5 class="text-warning">管理者よりアクセス許可を頂いてください</h5>

</div>

@stop

@section('css')
@stop

@section('js')
@stop





<!--{{--
    @extends('errors::minimal')
    @section('title', __('Forbidden'))
    @section('code', '403')
    @section('message', __($exception->getMessage() ?: 'Forbidden'))
--}}-->