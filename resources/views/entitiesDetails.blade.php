@extends('layouts.default')
@section('content')

<!-- <p> Isto é o id recebido: <?= $id ?> </p> -->
<p> Isto é o id recebido com angular: {{$id}}</p>

<div ng-controller="dynamicSearchControllerJs"> 
	<form id="dynamic-search">
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
	                <td ng-if="ents.properties.length == 0" colspan="4"> A entidade [[ents.language[0].pivot.name ]] não tem propriedades:  </td>

	                <div ng-if = "ents.properties.length > 0">
		                <tr ng-repeat="(key1, property) in ents.properties">
		                    <td>[[ property.id ]]</td>
		                    <td>[[ property.language[0].pivot.name ]]</td>
		                    <td><input type="checkbox" name = "checkET[[ key1 ]]" value = "[[ property.id ]]"> </td>
		                    <td>
		                    	<div ng-switch on="property.value_type">
							        <div ng-switch-when="text"> <input type="text" name="textET[[ $index ]]"> </div>
							        <div ng-switch-when="bool"> 
							        	<input type="radio" name="radioET[[ key1 ]]" value="true">True
										<input type="radio" name="radioET[[ key1 ]]" value="false">False 
									</div>
									<div ng-switch-when="enum">
										<select name = "selectET[[ key1 ]]" ng-init = "getEnumValues(property.id)">
							        		<option ng-repeat = "propAllowedValue in propAllowedValues[property.id]"> [[ propAllowedValue.language[0].pivot.name ]] </option>
							        	</select>
									</div>
									<div ng-switch-when="ent_ref"> 
										<select name = "ent_refET[[ key1 ]]" ng-init = "getEntityInstances(ents.id, property.id)">
							        		<option></option>
							        		<option ng-repeat = "inst in fkEnt[property.id].fk_ent_type.entity" value = "[[ inst.id ]]"> [[ inst.language[0].pivot.name ]] </option>
							        	</select>
									</div>
							        <div ng-switch-when="int"> 
										<select name = "operatorsET[[ key1 ]]" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="intET[[ key1 ]]">
									</div>
									<div ng-switch-when="double"> 
										<select name = "operatorsET[[ key1 ]]" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="doubleET[[ key1 ]]">
									</div>
									<div ng-switch-when="file"> <input type="text" name="fileET[[ key1 ]]"> </div>
									<!-- Não sei se é para por o prop-ref -->
									<div ng-switch-default> 
							        	<input type="text" name="propRefET[[ key1 ]]">
									</div>
								</div>
		                    </td> 
		                </tr>


	            	</div>
            	</tbody>
			</table>
			<!-- Todas as propriedades (de entidades) (cujo value_type é igual a ent_ref??) que referenciem a entidade em questão -->
			<!-- Esta tabela mostra as propriedades das entidades que contenham pelo menos uma prop que seja ent_ref e que a ent referenciada seja a entidade selecionada anteriormente -->
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
					                <tr ng-repeat="(key2, propOfEnt) in propsOfEnts[entRef.ent_type_id]" >
					                    <td>[[ propOfEnt.id ]]</td>
					                    <td>[[ propOfEnt.language[0].pivot.name ]]</td>
					                    <td><input type="checkbox" name = "checkVT[[ key2 ]]" value = "[[ propOfEnt.id ]]"> </td>
					                    <td>
					                    	<div ng-switch on="propOfEnt.value_type">
										        <div ng-switch-when="text"> <input type="text" name="textVT[[ key2 ]]"> </div>
										        <div ng-switch-when="bool"> 
										        	<input type="radio" name="radioVT[[ key2 ]]" value="true">True
													<input type="radio" name="radioVT[[ key2 ]]" value="false">False 
												</div>
												<div ng-switch-when="enum">
													<select name = "selectVT[[ key2 ]]" ng-init = "getEnumValues(propOfEnt.id)">
										        		<option ng-repeat = "propAllowedValue in propAllowedValues[propOfEnt.id]"> [[ propAllowedValue.language[0].pivot.name ]] </option>
										        	</select>
												</div>
												<!-- <div ng-switch-when="ent_ref"> 
													<select name = "ent_refVT[[ propOfEnt.id ]]" ng-init = "getEntityInstances(ents.id, propOfEnt.id)">
										        		<option></option>
										        		<option ng-repeat = "inst in fkEnt[propOfEnt.id].fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
										        	</select>
												</div> -->
										        <div ng-switch-when="int"> 
													<select name = "operatorsVT[[ key2 ]]" ng-init = "getOperators()">
										        		<option></option>
										        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
										        	</select>
										        	<input type="text" name="intVT[[ key2 ]]">
												</div>
												<div ng-switch-when="double"> 
													<select name = "operatorsVT[[ key2 ]]" ng-init = "getOperators()">
										        		<option></option>
										        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
										        	</select>
										        	<input type="text" name="doubleVT[[ key2 ]]">
												</div>
												<div ng-switch-when="file"> 
													<input type="text" name="fileVT[[ key2 ]]">
												</div>
												<!-- Não sei se é para por o prop-ref -->
												<div ng-switch-default> 
										        	<input type="text" name="propRefVT[[ key2 ]]">
												</div>
											</div>
					                    </td>
				                	</tr>
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

		                <tr ng-repeat="(key3, prop) in relWithEnt.properties" >
		                    <td>[[ prop.language[0].pivot.name ]]</td>
		                    <td> <input type="checkbox" name="checkRL[[ key3 ]]" value="[[ prop.id ]]"> </td>
		                    <td>
		                    	<div ng-switch on="prop.value_type">
							        <div ng-switch-when="text"> <input type="text" name="textRL[[ key3 ]]"> </div>
							        <div ng-switch-when="bool"> 
							        	<input type="radio" name="radioRL[[ key3 ]]" value="true">True
										<input type="radio" name="radioRL[[ key3 ]]" value="false">False 
									</div>
									<div ng-switch-when="enum">
										<select name = "selectRL[[ key3 ]]" ng-init = "getEnumValues(prop.id)">
							        		<option ng-repeat = "propAllowedValue in propAllowedValues[prop.id]"> [[ propAllowedValue.language[0].pivot.name ]] </option>
							        	</select>
									</div>
									<div ng-switch-when="ent_ref"> 
										<select name = "ent_refRL[[ key3 ]]" ng-init = "getEntityInstances(ents.id, prop.id)">
							        		<option></option>
							        		<option ng-repeat = "inst in fkEnt.fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
							        	</select>
									</div>
							        <div ng-switch-when="int"> 
										<select name = "operatorsRL" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="intRL[[ key3 ]]">
									</div>
									<div ng-switch-when="double"> 
										<select name = "operatorsRL[[ key3 ]]" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="text" name="doubleRL[[ key3 ]]">
									</div>
									<div ng-switch-when="file"> 
										<input type="text" name="fileRL[[ key3 ]]">
									</div>
									<!-- Não sei se é para por o prop-ref -->
									<div ng-switch-default> 
							        	<input type="text" name="propRefRL[[ key3 ]]">
									</div>
								</div>
		                    </td>
		                    <tr ng-repeat-end ng-if="false"></tr>
		                </tr>
                    </tbody>
                </table>
			</div>

			<!-- 4º tabela , falta corrigir o rowspan-->
			<div ng-init = "getEntsRelated(relWithEnt.id, {{ $id }})">
				<h3> Entidades que se relacionam com [[ents.language[0].pivot.name ]] </h3>

				<div ng-if="relsWithEnt.length == 0" colspan="4"> Não existe ents que se relacionem com [[ents.language[0].pivot.name ]] </div>

				<div ng-if="relsWithEnt.length > 0"> 
					<table class="table" border = "1px solid">
	                    <thead>
	                        <th>Entidade</th>
	                        <th>Propriedade</th>
	                        <th>Seleção</th>
	                        <th>Valor</th>
	                    </thead>
	                    <tbody ng-repeat="entRelated in entsRelated" >

	                    	<!-- <tr ng-repeat-start="entRelated in entsRelated" ng-if="false" ng-init="innerIndex = $index"></tr>

			                <td rowspan="[[ entRelated.properties.length + 1 ]] ">
			                    [[ entRelated.language[0].pivot.name ]]
			                </td> -->

			               <!--  <td ng-if="entRelated.properties.length == 0" colspan="3"> Ent Não tem props </td> -->

			               	<tr ng-repeat="property in entRelated.properties" >
			               		<td ng-if = "entRelated.ent_type1_id == ents.id" >
			               				[[ entRelated.ent2.language[0].pivot.name ]]
								</td>
		               			<td ng-if = "entRelated.ent_type2_id == ents.id" > 
		               				[[ entRelated.ent1.language[0].pivot.name ]]
		               			</td>
			                    <td>[[ property.language[0].pivot.name ]]</td>
			                    <td> <input type="checkbox" name="checkER[[ property.key ]]" value="[[ property.id ]]"> </td>
			                    <td>	
			                    	<div ng-switch on="property.value_type">
								        <div ng-switch-when="text">
								        	<input type="text" name="textER[[ property.key ]]"> 
								        </div>
								        <div ng-switch-when="bool"> 
								        	<input type="radio" name="radioER[[ property.key ]]" value="true">True
											<input type="radio" name="radioER[[ property.key ]]" value="false">False 
										</div>
										<div ng-switch-when="enum">
											<select name = "selectER[[ property.key ]]" ng-init = "getEnumValues(property.id)">
								        		<option ng-repeat = "propAllowedValue in propAllowedValues[property.id]"> [[ propAllowedValue.language[0].pivot.name ]] </option>
								        	</select>
										</div>
										<div ng-switch-when="ent_ref"> 
											<select name = "ent_refER[[ property.key ]]" ng-init = "getEntityInstances(property.ent_type_id, property.id)">
								        		<option></option>
								        		<option ng-repeat = "inst in fkEnt[property.id].fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
								        	</select>
										</div>
								        <div ng-switch-when="int"> 
											<select name = "operatorsER[[ property.key ]]" ng-init = "getOperators()">
								        		<option></option>
								        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
								        	</select>
								        	<input type="text" name="intER[[ property.key ]]">
										</div>
										<div ng-switch-when="double"> 
											<select name = "operatorsER[[ property.key ]]" ng-init = "getOperators()">
								        		<option></option>
								        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
								        	</select>
								        	<input type="text" name="doubleER[[ property.key ]]">
										</div>
										<div ng-switch-when="file"> 
											<input type="text" name="fileER[[ property.key ]]">
										</div>
										<!-- Não sei se é para por o prop-ref -->
										<div ng-switch-default> 
								        	<input type="text" name="propRefER[[ key3 ]]">
										</div>
									</div>
			                    </td>
			                </tr>
	                    </tbody> 
	                </table>
                </div>
            </div>
            <button type="button" class="btn btn-md btn-primary" ng-click="pesquisa(ents.id)"> Pesquisar </button>
		</div>
	</form>

	<div id="dynamic-search-presentation" style="display: none;">
		<h3>Resultado</h3>

		<button type="button" class="btn btn-md btn-primary" ng-click="voltar()"> Voltar </button>
	</div>
</div>

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop