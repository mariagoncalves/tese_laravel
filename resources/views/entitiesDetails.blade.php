@extends('layouts.default')
@section('content')

<!-- <p> Isto é o id recebido: <?= $id ?> </p> -->
<p> Isto é o id recebido com angular: {{$id}}</p>

<form>
	<div ng-controller="dynamicSearchControllerJs"> 
		<div ng-init = "getEntitiesData({{$id}})">
			<h3>Lista de propriedades da entidade [[ents.language[0].pivot.name ]] </h3>
			<table class="table table-striped" border = "1px solid">
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
							        <!-- <div ng-switch-default>
							        	<select name = "operators" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="doubleER">
							        </div> -->
							        <div ng-switch-when="int"> 
										<select name = "operators" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="intRL">
									</div>
									<div ng-switch-when="double"> 
										<select name = "operators" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="doubleRL">
									</div>
								</div>
		                    </td>
		                </tr>
	            	</div>
            	</tbody>
			</table>
			<!-- Todas as propriedades (de entidades) (cujo value_type é igual a ent_ref??) que referenciem a entidade em questão -->
			<div ng-init = "getEntRefs({{$id}})">
				<h3> Propriedades de entidades que contenham pelo menos uma propriedade que referêncie a entidade [[ents.language[0].pivot.name ]] </h3>

				<div ng-if = "entRefs.length == 0">
					<p> Não existem propriedades de entidades que referenciem a entidade [[ents.language[0].pivot.name ]] </p>
				</div>

				<div ng-if = "entRefs.length > 0">
					<div ng-repeat = "entRef in entRefs">
						<h4> Tipo de Entidade: [[ entRef.ent_type.language[0].pivot.name ]] </h4>

						<table class="table table-striped" border = "1px solid">
				            <thead>
				                <tr>
				                    <th>Id</th>
				                    <th>Nome da propriedade</th>
				                    <th>Seleção</th>
				                    <th>Valor</th>
				                </tr>
				            </thead>
					        <tbody>
				                <div ng-init = "getPropsOfEnts(entRef.ent_type_id)">
			                		<!-- <div ng-if = "propOfEnt.value_type != 'ent_Ref'">  -->
						                <tr ng-repeat="propOfEnt in propsOfEnts">
						                    <td>[[ propOfEnt.id ]]</td>
						                    <td>[[ propOfEnt.language[0].pivot.name ]]</td>
						                    <td><input type="checkbox" name = "" value = "[[ propOfEnt.id ]]"> </td>
						                    <td>
						                    	<div ng-switch on="propOfEnt.value_type">
											        <div ng-switch-when="text"> <input type="text" name=""> </div>
											        <div ng-switch-when="bool"> 
											        	<input type="radio" name="radioVT" value="true">True
														<input type="radio" name="radioVT" value="false">False 
													</div>
													<div ng-switch-when="enum">
														<select name = "selectET" ng-init = "getEnumValues(propOfEnt.id)">
											        		<option ng-repeat = "propAllowedValue in propAllowedValues"> [[ propAllowedValue.language[0].pivot.name ]] </option>
											        	</select>
													</div>
													<div ng-switch-when="ent_ref"> 
														<select name = "ent_refER" ng-init = "getEntityInstances(ents.id, property.id)">
											        		<option></option>
											        		<option ng-repeat = "inst in fkEnt.fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
											        	</select>
													</div>
											        <!-- <div ng-switch-default>
											        	<select name = "operators" ng-init = "getOperators()">
											        		<option></option> 
											        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
											        	</select>
											        	<input type="text" name="doubleER">
											        </div> -->
											        <div ng-switch-when="int"> 
														<select name = "operators" ng-init = "getOperators()">
											        		<option></option>
											        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
											        	</select>
											        	<input type="text" name="intRL">
													</div>
													<div ng-switch-when="double"> 
														<select name = "operators" ng-init = "getOperators()">
											        		<option></option>
											        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
											        	</select>
											        	<input type="text" name="doubleRL">
													</div>
												</div>
						                    </td>
					                	</tr>
						            <!-- </div> -->
				            	</div>
			            	</tbody>
						</table>
					</div>
				</div>
			</div>

			<!-- 3º tabela -->
			<div ng-init = "getRelsWithEnt({{$id}})">
				<h3> Propriedades de relações em que a entidade [[ents.language[0].pivot.name ]] está presente. </h3>
				<table class="table" border = "1px solid">
                    <thead>
                        <th>Tipo Relação</th>
                        <th>Propriedade da Relação</th>
                        <th>Seleção</th>
                        <th>Valor</th>
                    </thead>
                    <tbody>
		                <tr ng-repeat-start="relWithEnt in relsWithEnt" ng-if="false" ng-init="innerIndex = $index"></tr>

		                <td rowspan="[[ relWithEnt.properties.length + 1 ]] ">
		                    [[ relWithEnt.language[0].pivot.name ]]
		                </td>

		                <td ng-if="relWithEnt.properties.length == 0" colspan="3"> Rel Não tem props </td>

		                <tr ng-repeat="prop in relWithEnt.properties">
		                    <td>[[ prop.language[0].pivot.name ]]</td>
		                    <td> <input type="checkbox" name="checkRL" value="[[ prop.id ]]"> </td>
		                    <td>
		                    	<div ng-switch on="prop.value_type">
							        <div ng-switch-when="text"> <input type="text" name="textRL"> </div>
							        <div ng-switch-when="bool"> 
							        	<input type="radio" name="radioRL" value="true">True
										<input type="radio" name="radioRL" value="false">False 
									</div>
									<div ng-switch-when="enum">
										<select name = "selectRL" ng-init = "getEnumValues(prop.id)">
							        		<option ng-repeat = "propAllowedValue in propAllowedValues"> [[ propAllowedValue.language[0].pivot.name ]] </option>
							        	</select>
									</div>
									<div ng-switch-when="ent_ref"> 
										<select name = "ent_refER" ng-init = "getEntityInstances(ents.id, prop.id)">
							        		<option></option>
							        		<option ng-repeat = "inst in fkEnt.fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
							        	</select>
									</div>
							        <div ng-switch-when="int"> 
										<select name = "operators" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="intRL">
									</div>
									<div ng-switch-when="double"> 
										<select name = "operators" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="doubleRL">
									</div>
								</div>
		                    </td>
		                    <tr ng-repeat-end ng-if="false"></tr>
		                </tr>
                    </tbody>
                </table>
			</div>

			<!-- 4º tabela -->
			<div>
				<h3> Entidades que se relacionam com [[ents.language[0].pivot.name ]] </h3>


			</div>


		</div>
	</div>
	<input type="hidden" name="estado" value="execucao">
	<input type="submit" value="Pesquisar">
</form>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop