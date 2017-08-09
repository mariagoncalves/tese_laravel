
    <ul class="nav navbar-nav side-nav">
        <li class="active">
            <a href="/dashboardManage"><i class="fa fa-fw fa-dashboard"></i> Menu</a>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-bar-chart-o"></i> Process Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo" class="collapse">
                <li>
                    <a href="/processTypesManage">Process Kinds</a>
                </li>
                <li>
                    <a href="/processesManage">Processes</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-bar-chart-o"></i> Transaction Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo1" class="collapse">
                <li>
                    <a href="/transactionTypesManage">Transaction Kinds</a>
                </li>
                <li>
                    <a href="/tStatesManage">T State</a>
                </li>
                <li>
                    <a href="/transactionsManage">Transactions</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="fa fa-fw fa-bar-chart-o"></i> Entities Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo2" class="collapse">
                <li>
                    <a href="/entityTypesManage">Entity Kinds</a>
                </li>
                <li>
                    <a href="/">Entities</a>
                </li>
            </ul>
        </li>
		<li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo3"><i class="fa fa-fw fa-bar-chart-o"></i> Process Structure Diagram <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo3" class="collapse">
                <li>
                    <a href="/CausalLinksManage">Causal Links</a>
                </li>
                <li>
                    <a href="/WaitingLinksManage">Waiting Links</a>
                </li>
            </ul>
        </li>
		<li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo4"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("messages.manageProperties") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo4" class="collapse">
                <li>
                    <a href="/propertiesManageEnt">Entity</a>
                </li>
                <li>
                    <a href="/propertiesManageRel">Relation</a>
                </li>
				<li>
					<a href="propAllowedValueManage">Allowed Values</a>
				</li>
            </ul>
        </li>
		<li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo15"><i class="fa fa-fw fa-bar-chart-o"></i> {{trans("messages.relationManagment") }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo15" class="collapse">
                <li>
                    <a href="/relationTypesManage">{{trans("messages.relationTypes") }}</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="fa fa-fw fa-bar-chart-o"></i> Units Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo5" class="collapse">
                <li>
                    <a href="/propUnitTypeManage">Unit Kinds</a>
                </li>
                <li>
                    <a href="/">Units</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo6"><i class="fa fa-fw fa-bar-chart-o"></i> Actor Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo6" class="collapse">
                <li>
                    <a href="/actorsManage">Actors</a>
                </li>
                {{--<li>--}}
                    {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo7"><i class="fa fa-fw fa-bar-chart-o"></i> Roles Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo7" class="collapse">
                <li>
                    <a href="/rolesManage">Roles</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo8"><i class="fa fa-fw fa-bar-chart-o"></i> Languages Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo8" class="collapse">
                <li>
                    <a href="/languagesManage">Languages</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#demo9"><i class="fa fa-fw fa-bar-chart-o"></i> Users Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="demo9" class="collapse">
                <li>
                    <a href="/usersManage">Users</a>
                </li>
                {{--<li>--}}
                {{--<a href="/">Entities</a>--}}
                {{--</li>--}}
            </ul>
        </li>
    </ul>