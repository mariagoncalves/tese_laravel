@extends('layouts.default')
@section('content')

<!-- <p> Isto é o id recebido: <?= $id ?> </p> -->
<p> Isto é o id recebido com angular: {{$id}}</p>

<form>
	<div ng-controller="dynamicSearchControllerJs"> 
		<div ng-init = "getEntitiesData({{$id}})">
			<h3>Lista de propriedades da entidade [[ents.language[0].pivot.name ]] </h3>
			<table class="table table-striped">
	            <thead>
	                <tr>
	                    <th>Id</th>
	                    <th>Nome da propriedade</th>
	                    <th>Seleção</th>
	                    <th>Valor</th>
	                </tr>
	            </thead>
		        <tbody>
	                <td ng-if="ents.properties.length == 0" colspan="4"> Não tem propriedades </td>

	                <div ng-if = "ents.properties.length > 0">
		                <tr ng-repeat="property in ents.properties">
		                    <td>[[ property.id ]]</td>
		                    <td>[[ property.language[0].pivot.name ]]</td>
		                    <td><input type="checkbox" name = "" value = "[[ property.id ]]"> </td>
		                    <td> </td>
		                </tr>
	            	</div>
            	</tbody>
			</table> 
		</div>
	</div>
	<input type="hidden" name="estado" value="execucao">
	<input type="submit" value="Pesquisar">
</form>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop