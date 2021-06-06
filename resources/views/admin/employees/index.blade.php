@extends('admin.app')
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> List Employees</h1>
        </div>
        <a href="{{route('admin.employees.attendance')}}" class="btn btn-primary pull-right">Employees Attendance <i class="fa fa-fw fa-lg fa-arrow-right"></i></a>
        <a href="{{route('admin.employees.create')}}" class="btn btn-primary pull-right">Add Employee</a>
       
    </div>
    @include('messages.alerts')


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <h1 class="d-block text-center">Complex Search</h1>
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Join Date From</th>
                            <th>Join Date To</th>
                            <th>Salary From</th>
                            <th>Salary To</th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <form action="{{route('admin.employees.search')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <td><input type="text" name="name" style="width:140px;"></td>
                                        <td><input type="text" name="designation" style="width:140px;"></td>
                                        <td><input type="text" name="department" style="width:140px;"></td>
                                        <td><input type="date" name="join_date_from" style="width:150px;"></td>
                                        <td><input type="date" name="join_date_to" style="width:150px;"></td>
                                        <td><input type="number" name="salary_from" style="width:100px;"></td>
                                        <td><input type="number" name="salary_to" style="width:100px;"></td>
                                    
                                        <td class="text-center">
                                             <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                           
                                            {{--<div class="btn-group" role="group" aria-label="Second group">
                                                <form 
                                                        action="{{ route('admin.employees.delete', $employee->id) }}"
                                                        method="POST"
                                                        >
                                                        @csrf
                                                        @method('DELETE')
                                                            <button type="submit" class="btn btn-sm flat btn-danger ml-1"><i class="fa fa-trash"></i></button>
                                                    </form> 
                                            </div> --}}
                                        </td>
                                    </form>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if ($employees->count())
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Join Date</th>
                            <th>Salary</th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $employee->first_name}}</td>
                                    <td>{{ $employee->department->name }}</td>
                                    <td>{{ $employee->desg }}</td>
                                    <td>{{ $employee->join_date->format('d M, Y') }}</td>
                                    <td class="text-center">
                                       {{ $employee->salary }} 
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-edit"></i></a>
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <form 
                                                    action="{{ route('admin.employees.delete', $employee->id) }}"
                                                    method="POST"
                                                    >
                                                    @csrf
                                                    @method('DELETE')
                                                        <button type="submit" class="btn btn-sm flat btn-danger ml-1"><i class="fa fa-trash"></i></button>
                                                </form> 
                                        </div>
                                    </td>
                                </tr>
                           @endforeach
                        </tbody>
                    </table>
                     @else
                        <div class="alert alert-info text-center" style="width:50%; margin: 0 auto">
                            <h4>No Records Available</h4>
                        </div>
                       
                    @endif
                </div>
            </div>
        </div>
    </div>

    
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush