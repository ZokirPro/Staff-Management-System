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
        
    </ul>
</aside>