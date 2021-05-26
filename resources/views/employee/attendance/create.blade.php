@extends('employee.app')        

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Register Attendance</h1>
                </div>  
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('employee.index') }}">Employee Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Register Attendance
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 mx-auto">
                    <!-- general form elements -->
                    <div class="card card-primary text-center">
                        <div class="card-header">
                            <h3 class="card-title">Today's Attendance</h3>
                        </div>
                        <!-- /.card-header -->
                        @include('messages.alerts')
                        <!-- form start -->
                        @if (!$attendance)
                        <form role="form" method="post" action="{{ route('employee.attendance.store', $employee->id) }}" >
                        @else
                        <form role="form" method="post" action="{{ route('employee.attendance.update', $attendance->id) }}" >
                            @method('PUT')
                        @endif
                            @csrf
                            <div class="card-body ml-5 ">
                                @if (!$attendance)
                                <div class="row ml-3">
                                    <div class="col-md-8 ">
                                        <div class="form-group ">
                                            <label for="entry_time">Entry Time</label>
                                            <input
                                            type="time"
                                            class="form-control text-center"
                                            name="entry_time"
                                            id="entry_time"
                                            placeholder=""
                                            disabled
                                            />
                                        </div>
                                    </div>

                                </div>
                                @else
                                <div class="row ml-3">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="entry_time">Entry Time</label>
                                            <input
                                            type="time"
                                            value="{{ $attendance->created_at->format('d-m-Y,  H:i:s') }}"
                                            class="form-control text-center"
                                            name="entry_time"
                                            id="entry_time"
                                            placeholder=""
                                            disabled
                                            style="background: #333; color:#f4f4f4"
                                            />
                                        </div>
                                    </div>
                                    
                                </div>
                                @endif
                                @if (!$registered_attendance)
                                <div class="row ml-3">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exit_time">Exit Time</label>
                                            <input
                                            type="time"
                                            class="form-control text-center"
                                            name="exit_time"
                                            id="exit_time"
                                            placeholder=""
                                            disabled
                                            />
                                        </div>
                                    </div>
                                   
                                </div>
                                @else
                                <div class="row ml-3">
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exit_time">Exit Time</label>
                                            <input
                                            type="time"
                                            class="form-control text-center"
                                            name="exit_time"
                                            id="exit_time"
                                            value="{{ $attendance->updated_at->format('d-m-Y,  H:i:s') }}"
                                            placeholder=""
                                            disabled
                                            style="background: #333; color:#f4f4f4"
                                            />
                                        </div>
                                    </div>
                                    
                                </div>
                                @endif
                                
                                
                            </div>
                            <!-- /.card-body -->
                            @if (!$registered_attendance)
                            <div class="card-footer" >
                                @if (!$attendance)
                                <button type="submit" class="btn btn-primary p-3" style="font-size:1.2rem">
                                    Record Entry
                                </button>    
                                @else
                                <button type="submit" class="btn btn-primary pull-right p-3" style="font-size:1.2rem">
                                    Record Exit
                                </button>
                                @endif
                            </div>   
                            @endif
                            
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection