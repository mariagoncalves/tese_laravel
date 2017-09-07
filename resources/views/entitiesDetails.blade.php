@extends('layouts.default')
@section('content')

<!-- <p> Isto é o id recebido: <?= $id ?> </p> -->



@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop