@extends('layouts.default')
@section('content')
<div ng-controller="dynamicSearchControllerJs">
	<h2>Pesquisas guardadas</h2>

	<div ng-init = "getSavedQueries()">
		<ul>
			<li ng-repeat = "query in queries"> [[query.name]] </li>
		</ul>
	</div>

	<table border = "1px">
		<thead>
            <th>Nome da Query </th>
            <th>Entidade</th>
            <th>Propriedade</th>
            <th>Operador</th>
            <th>Valor</th>
        </thead>
        <tbody>
        	<tr ng-repeat-start="query in queries" ng-if="false" ng-init="innerIndex = $index"></tr>

        	<td rowspan="[[ query.condicions.length + 1 ]] "> [[ query.name ]] <button type = "button" ng-click = "showQueryResults()" > Pesquisar </button> </td>
        	<td rowspan="[[ query.condicions.length + 1 ]] "> [[ query.ent_type.language[0].pivot.name ]] </td>

            <tr ng-repeat="condition in  query.condicions" >
            	<td>[[ condition.property.language[0].pivot.name ]]</td>
            	<td>[[ condition.operator.operator_type ]]</td>
            	<td> [[ condition.value == "" ? "Sem valor atribuído" : condition.value ]] </td>
            	<tr ng-repeat-end ng-if="false"></tr>
            </tr>
        </tbody>
	</table>
</div>

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop