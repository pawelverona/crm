@extends('layouts.main')
@section('content')
    <link href="{{ asset('/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista Pracowników
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="start_stop">
                                <div class="panel-body table-responsive">
                                    <table id="datatable" class="thead-inverse table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Imię Wypełniającego</th>
                                            <th>Nazwisko Wypełniającego</th>
                                            <th>Department</th>
                                            <th>Data</th>
                                            <th>Imię trenera</th>
                                            <th>Nazwisko trenera</th>
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
        </div>
    </div>



@endsection
@section('script')
    <script src="{{ asset('/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready( function () {

            table = $('#datatable').DataTable({
                "autoWidth": true,
                "processing": true,
                "serverSide": true,
                "drawCallback": function( settings ) {
                },
                "ajax": {
                    'url': "{{ route('api.auditTable') }}",
                    'type': 'POST',
                    'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Polish.json"
                },"columns":[
                    {"data": "first_name"},
                    {"data": "last_name"},
                    {"data": "department"},
                    {"data": "date_audit"},
                    {"data": "trainer_first_name"},
                    {"data": "trainer_last_name"}
                ]
            });

            // $('.search-input-text').on( 'change', function () {   // for text boxes
            //     var i =$(this).attr('data-column');  // getting column index
            //     var v = $(this).find("option:selected").text()  // getting search input value
            //     table.columns(i).search(v).draw();
            // } );
        });
    </script>

@endsection
