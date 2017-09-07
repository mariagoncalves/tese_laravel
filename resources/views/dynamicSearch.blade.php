@extends('layouts.default')
@section('content')

<h3> Pesquisa dinâmica - Escolher tipo de entidade</h3>
<div ng-controller="dynamicSearchControllerJs">
	<div ng-init="getEntities()">
		<div ng-if = "entity.length == 0">
			<p> Não pode efetuar pesquisas uma vez que ainda não foram introduzidos tipos de entidades. </p>
		</div>
		<div ng-if = "entity.length != 0">
			<ul ng-repeat="entity in entities"> 
				<!-- <li> <a ng-click = "getEntitiesData(entity.id)"> [[ entity.language[0].pivot.name ]] </a> </li> -->
				<li> <a href = "/dynamicSearch/entityDetails/[[entity.id]]"> [[ entity.language[0].pivot.name ]] </a> </li>
			</ul>
		</div>
	</div>
</div>

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop