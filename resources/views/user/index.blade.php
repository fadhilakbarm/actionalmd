@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Users</h1>
@stop

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        table.dataTable thead th {
            background-image: none !important;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-right">
                <a href="{{route('user.create')}}" class="btn btn-primary">Add Data</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <div class="box box-primary">
                            <table class="table table-bordered" id="table-users">
                                <thead>
                                    <tr>                                           
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Gender</th>                        
                                        <th>Age</th>                        
                                        <th>Joined Date</th>                                                
                                        <th>Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.7/sweetalert2.all.min.js"></script>
    <script>
        let table = $('#table-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.data') }}",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            columns: [
                {data: 'first_name', name: 'first_name', defaultContent: '-'},
                {data: 'last_name', name: 'last_name', defaultContent: '-'},
                {data: 'gender', name: 'gender', defaultContent: '-'},
                {data: 'age', name: 'age', defaultContent: '-'},
                {data: 'joined_date', name: 'joined_date', defaultContent: '-'},
                {data: 'menu', orderable: false, searchable: false}
            ]
        });

        function deleteData(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it.'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:" {{ url('user/')}}/" + id,
                        type: 'DELETE',
                    })
                    .done(function(res) {
                        swal(
                            'Deleted!',
                            'Your data has been deleted.',
                            'success'
                        )

                        $('#table-users').DataTable().ajax.url("{{ route('user.data') }}").load();
                    })
                }
            })
        }
    </script>
@stop