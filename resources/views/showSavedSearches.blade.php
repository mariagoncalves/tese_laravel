@extends('layouts.default')
@section('content')

<h2>Pesquisas guardadas</h2>

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop