@extends('admin.app')        

@section('content')



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Employee</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Add Employee
                    </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto">
                <div class="card card-primary">
                    <div class="card-header bg-primary">
                        <h5 class="text-center mt-2 text-white">Add New Employee</h5>
                    </div>
                    @include('messages.alerts')
                    <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label" for="first_name">First Name</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Enter First Name"
                                        id="first_name"
                                        name="first_name"
                                        value="{{ old('first_name') }}"
                                    />
                                    @error('first_name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="last_name">Last Name</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Enter First Name"
                                        id="last_name"
                                        name="last_name"
                                        value="{{ old('last_name') }}"
                                    />
                                     @error('last_name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="email">Email</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        placeholder="Enter Email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                    />
                                     @error('email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                 <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="text" name="dob" id="dob" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <select name="sex" class="form-control">
                                        <option hidden disabled selected value> -- select an option -- </option>
                                        @if (old('sex') == 'Male')
                                        <option value="Male" selected>Male</option>
                                        <option value="Female">Female</option>
                                        @elseif (old('sex') == 'Female')
                                        <option value="Male">Male</option>
                                        <option value="Female" selected>Female</option>
                                        @else
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        @endif
                                    </select>
                                    @error('sex')
                                        <div class="text-danger">
                                            Please select an valid option
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="join_date">Join Date</label>
                                    <input type="text" name="join_date" id="join_date" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Designation</label>
                                        <select name="desg" class="form-control">
                                            <option hidden disabled selected value> -- select an option -- </option>
                                            @foreach ($desgs as $desg)
                                                <option value="{{ $desg }}"
                                                @if (old('desg') == $desg)
                                                    selected
                                                @endif
                                                >
                                                    {{ $desg }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('desg')
                                        <div class="text-danger">
                                            Please select an valid option
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Department</label>
                                        <select name="department_id" class="form-control">
                                            <option hidden disabled selected value> -- select an option -- </option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if (old('department_id') == $department->id)
                                                        selected
                                                    @endif    
                                                >
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department')
                                        <div class="text-danger">
                                            Please select a valid option
                                        </div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Salary</label>
                                    <input type="text" name="salary" value="{{ old('salary') }}" class="form-control">
                                    @error('salary')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Photo</label>
                                    <input type="file" name="photo" class="form-control-file">
                                    @error('photo')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control">
                                    @error('password')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control">
                                    @error('password_confirmation')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="tile-footer">
                                    <div class="row d-print-none mt-2">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add Employee</button>
                                            <a class="btn btn-danger" href="{{route('admin.employees.index')}}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                                        </div>
                                    </div>
                                </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
   
@push('scripts')
<script>
    $().ready(function() {
        if('{{ old('dob') }}') {
            const dob = moment('{{ old('dob') }}', 'DD-MM-YYYY');
            const join_date = moment('{{ old('join_date') }}', 'DD-MM-YYYY');
            console.log('{{ old('dob') }}')
            $('#dob').daterangepicker({
                "startDate": dob,
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
            $('#join_date').daterangepicker({
                "startDate": join_date,
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
        } else {    
            $('#dob').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
            $('#join_date').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
        }
        
    });
</script>
@endpush