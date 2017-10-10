@extends('layouts.default')
@section('content')

<!-- <p> Isto é o id recebido: <?= $id ?> </p> -->
<!--<p> Isto é o id recebido com angular: {{$id}}</p>  -->

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
							        	<input type="number" name="intET[[ key1 ]]">
									</div>
									<div ng-switch-when="double"> 
										<select name = "operatorsET[[ key1 ]]" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="number" name="doubleET[[ key1 ]]">
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
				                <div>
				                	<td ng-if="entRef.properties.length == 0" colspan="4"> Não tem props </td>

					                <tr ng-repeat="propOfEnt in entRef.properties" >
					                    <td>[[ propOfEnt.id ]]</td>
					                    <td>[[ propOfEnt.language[0].pivot.name ]]</td>
					                    <td><input type="checkbox" name = "checkVT[[ propOfEnt.key ]]" value = "[[ propOfEnt.id ]]"> </td>
					                    <td>
					                    	<div ng-switch on="propOfEnt.value_type">
										        <div ng-switch-when="text"> <input type="text" name="textVT[[ propOfEnt.key  ]]"> </div>
										        <div ng-switch-when="bool"> 
										        	<input type="radio" name="radioVT[[ propOfEnt.key  ]]" value="true">True
													<input type="radio" name="radioVT[[ propOfEnt.key  ]]" value="false">False 
												</div>
												<div ng-switch-when="enum">
													<select name = "selectVT[[ propOfEnt.key  ]]" ng-init = "getEnumValues(propOfEnt.id)">
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
													<select name = "operatorsVT[[ propOfEnt.key  ]]" ng-init = "getOperators()">
										        		<option></option>
										        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
										        	</select>
										        	<input type="number" name="intVT[[ propOfEnt.key  ]]">
												</div>
												<div ng-switch-when="double"> 
													<select name = "operatorsVT[[ propOfEnt.key  ]]" ng-init = "getOperators()">
										        		<option></option>
										        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
										        	</select>
										        	<input type="number" name="doubleVT[[ propOfEnt.key  ]]">
												</div>
												<div ng-switch-when="file"> 
													<input type="text" name="fileVT[[ propOfEnt.key  ]]">
												</div>
												<!-- Não sei se é para por o prop-ref -->
												<div ng-switch-default> 
										        	<input type="text" name="propRefVT[[ propOfEnt.key ]]">
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
		                    <td> <input type="checkbox" name="checkRL[[ prop.key ]]" value="[[ prop.id ]]"> </td>
		                    <td>
		                    	<div ng-switch on="prop.value_type">
							        <div ng-switch-when="text"> <input type="text" name="textRL[[ prop.key ]]"> </div>
							        <div ng-switch-when="bool"> 
							        	<input type="radio" name="radioRL[[ prop.key ]]" value="true">True
										<input type="radio" name="radioRL[[ prop.key ]]" value="false">False 
									</div>
									<div ng-switch-when="enum">
										<select name = "selectRL[[ prop.key ]]" ng-init = "getEnumValues(prop.id)">
							        		<option ng-repeat = "propAllowedValue in propAllowedValues[prop.id]"> [[ propAllowedValue.language[0].pivot.name ]] </option>
							        	</select>
									</div>
									<div ng-switch-when="ent_ref"> 
										<select name = "ent_refRL[[ prop.key ]]" ng-init = "getEntityInstances(ents.id, prop.id)">
							        		<option></option>
							        		<option ng-repeat = "inst in fkEnt.fk_ent_type.entity"> [[ inst.language[0].pivot.name ]] </option>
							        	</select>
									</div>
							        <div ng-switch-when="int"> 
										<select name = "operatorsRL" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="number" name="intRL[[ prop.key ]]">
									</div>
									<div ng-switch-when="double"> 
										<select name = "operatorsRL[[ prop.key ]]" ng-init = "getOperators()">
							        		<option></option>
							        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
							        	</select>
							        	<input type="number" name="doubleRL[[ prop.key ]]">
									</div>
									<div ng-switch-when="file"> 
										<input type="text" name="fileRL[[ prop.key ]]">
									</div>
									<!-- Não sei se é para por o prop-ref -->
									<div ng-switch-default> 
							        	<input type="text" name="propRefRL[[ prop.key ]]">
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
	                    <tbody>

	                    	<tr ng-repeat-start="(position, entRelated) in entsRelated" ng-if="false" ng-init="innerIndex = $index"></tr>

			                <td ng-if="entRelated.properties.length != 0 && entRelated.ent_type1_id == ents.id" rowspan="[[ entRelated.properties.length + 1 ]] ">
			                    [[ entRelated.ent2.language[0].pivot.name ]]
			                </td>

			                <td ng-if="entRelated.properties.length != 0 && entRelated.ent_type2_id == ents.id" rowspan="[[ entRelated.properties.length + 1 ]] ">
			                    [[ entRelated.ent1.language[0].pivot.name ]]
			                </td>

			                <td ng-if="entRelated.properties.length == 0 && position == 0" colspan="4"> Não tem props </td>

			               	<tr ng-repeat="property in entRelated.properties" >
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
								        	<input type="number" name="intER[[ property.key ]]">
										</div>
										<div ng-switch-when="double"> 
											<select name = "operatorsER[[ property.key ]]" ng-init = "getOperators()">
								        		<option></option>
								        		<option ng-repeat = "operator in operators"> [[ operator ]] </option>
								        	</select>
								        	<input type="number" name="doubleER[[ property.key ]]">
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
			                    <tr ng-repeat-end ng-if="false"></tr>
			                </tr>
	                    </tbody> 
	                </table>
                </div>
            </div>
            <button type="button" class="btn btn-md btn-primary" ng-click="search(ents.id)"> Pesquisar </button>
		</div>
	</form>

	<div id="dynamic-search-presentation" style="display: none;">
		<h3>Pesquisa</h3>
		<div id="false-de-pesquisa" style="padding: 15px 0px;">
			<dl>
			  <dt>[[ resultDynamincSearch.phrase[0] ]]:</dt>
			  <dd ng-repeat = "(key, phrase) in resultDynamincSearch.phrase" ng-if="key != 0">[[ phrase ]]</dd>
			  <dd ng-if="resultDynamincSearch.phrase.length == 1 ">- Nenhuma pesquisa efetuada.</dd>	
			</dl>
		</div>

		<div>
			 <div growl></div>
			<table class="table" border = "1px solid">
	            <thead>
	            	<th>Ação</th>
	                <th>Instância</th>
	                <th width="85px">Estado da Instância</th>
	                <th>Propriedade</th>
	                <th>Valor</th>
	                <th width="80px">Estado do Valor</th>
	            </thead>
	            <tbody>
	            	<td ng-if="resultDynamincSearch.result.length == 0 " colspan="6">Não existem entidades que respeitem a pesquisa efetuada.</td>

	                <tr ng-repeat-start="entity in resultDynamincSearch.result" ng-if="false" ng-init="innerIndex = $index"></tr>

	               	<td rowspan="[[ entity.values.length + 1 ]] ">
	                    <button type="button" class="btn btn-xs btn-warning" ng-click="inactiveActive(entity.id)"> [[ entity.state == 'active' ? 'Desativar' : 'Ativar' ]] </button>
	                </td>

	                <td rowspan="[[ entity.values.length + 1 ]] ">
	                	[[ entity.language[0].pivot.name ]]
	                </td>

	                <td rowspan="[[ entity.values.length + 1 ]] ">
	                	[[ entity.state == 'active' ? 'Ativo' : 'Inativo' ]]
	                </td>

	                <td ng-if="entity.values.length == 0" colspan="4">Não existe propriedades.</td>

	                <tr ng-repeat="value in entity.values" >
	                    <td>[[ value.property.language[0].pivot.name ]]</td>
	                    <td>[[ value.state == 'active' ? (value.value == '' ? 'Sem Valor Atribuído' : value.value) : '-' ]]</td>
	                    <td>[[ value.state == 'active' ? 'Ativo' : 'Inativo' ]]</td>
	                    <tr ng-repeat-end ng-if="false"></tr>
	                </tr>
	            </tbody>
	        </table>
		</div>
		<button type="button" class="btn btn-md btn-primary" ng-click="voltar()"> Voltar </button>
	</div>
</div>

@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dynamicSearch.js') ?>"></script>
@stop