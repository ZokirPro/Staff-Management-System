<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.index' ? 'active' : '' }}" href="{{route('employee.index')}}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Employee Dashboard</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.attendance.index' ? 'active' : '' }}" href=" {{route('employee.attendance.index')}}">
                <i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Attendance</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'employee.expenses.index' ? 'active' : '' }}" href=" {{route('employee.expenses.index')}}">
                <i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Expenses</span>
            </a>
        </li>
        {{-- <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.expenses.index' ? 'active' : '' }}" href=" {{route('admin.expenses.index')}}">
                <i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Expenses</span>
            </a>
        </li> --}}
        {{-- <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">Employees</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Employees</a>
                </li>
                <li>
                    <a class="treeview-item" href="#" target="_blank" rel="noopener noreferrer"><i class="icon fa fa-circle-o"></i> Roles</a>
                </li>
                <li>
                    <a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Permissions</a>
                </li>
            </ul>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Settings</span>
            </a>
        </li> --}}
    </ul>
</aside>