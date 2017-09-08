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
	                <td ng-if="ents.properties.length == 0" colspan="4"> A entidade [[ents.language[0].pivot.name ]] não tem propriedades </td>

	                <div ng-if = "ents.properties.length > 0">
		                <tr ng-repeat="property in ents.properties">
		                    <td>[[ property.id ]]</td>
		                    <td>[[ property.language[0].pivot.name ]]</td>
		                    <td><input type="checkbox" name = "" value = "[[ property.id ]]"> </td>
		                    <td>
		                    	<div ng-switch on="property.value_type">
							        <div ng-switch-when="text"> <input type="text" name=""> </div>
							        <div ng-switch-when="bool"> 
							        	<input type="radio" name="radioET" value="true">True
										<input type="radio" name="radioET" value="false">False 
									</div>
									<div ng-switch-when="enum">
										<select name = "selectET" ng-init = "getEnumValues(property.id)">
							        		<option ng-repeat = "propAllowedValue in propAllowedValues"> [[ propAllowedValue.language[0].pivot.name ]] </option>
							        	</select>
									</div>
									<div ng-switch-when="ent_ref"> 
										<select name = "ent_refER" ng-init = "getEntityInstances(ents.id, property.id)">
							        		<option></option>
							        		<option ng-repeat = "inst in fkEnt.fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
							        	</select>
									</div>
							        <div ng-switch-default>
							        	<select name = "operators" ng-init = "getOperators()">
							        		<option></option> <!--This solves the problem that operatores always where sent in set state-->
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="doubleER">
							        </div>
								</div>
		                    </td>
		                </tr>
	            	</div>
            	</tbody>
			</table> 
		</div>

		<div>



		</div>



	</div>
	<input type="hidden" name="estado" value="execucao">
	<input type="submit" value="Pesquisar">
</form>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop