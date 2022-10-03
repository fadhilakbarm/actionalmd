@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')
    <h1>Add User</h1>
@stop

@section('css') 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>

    <style>
        .select2 {
            width: 100% !important;
        }
        
        .select2-container .select2-selection--single {
            height: auto !important;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['url' => route('user.store'), 'class' => 'form', 'method' => 'post']) !!}
                
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="form-label">First Name</label>
                        {!! Form::text('first_name', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="form-label">Last Name</label>
                        {!! Form::text('last_name', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                    </div>

                    <div class="form-group col-lg-6">
                        <label class="form-label">Age</label>
                        {!! Form::number('age', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                    </div>
                    
                    <div class="form-group col-lg-6">
                        <label class="form-label">Gender</label>
                        {!! Form::select('gender', ['male' => 'Male', 'female' => 'Female'], 'male', ['class'=>'form-control select2']) !!}
                    </div>

                    <div class="form-group mb-3 col-lg-3">
                        <label class="form-label">Joined Date</label>
                        <div class="col-lg-12">
                            <div class="input-group date">
                                {!! Form::text('joined_date', date('Y-m-d'), ['class'=>'form-control datepicker']) !!}

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="card-footer text-right">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
        </div>
    </div>
@stop


@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.select2').select2();
        
        $('.datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
    </script>
@stop