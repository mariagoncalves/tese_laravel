@extends('layouts.default')
@section('content')


<h3> {{trans("dynamicSearch.Page_Name")}}</h3>
<div ng-controller="dynamicSearchControllerJs">
	<div ng-init="getEntities()">
		<div ng-if = "entity.length == 0">
			<p> {{trans("dynamicSearch.No_Entities_message")}} </p>
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