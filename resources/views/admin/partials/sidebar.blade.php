<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.index' ? 'active' : '' }}" href="{{route('admin.index')}}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Admin Dashboard</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.employees.index' ? 'active' : '' }}" href=" {{route('admin.employees.index')}}">
                <i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Employees</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.expenses.index' ? 'active' : '' }}" href=" {{route('admin.expenses.index')}}">
                <i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Expenses</span>
            </a>
        </li>
    </ul>
</aside>