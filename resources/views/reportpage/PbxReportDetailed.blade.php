@extends('layouts.main')
@section('style')
    <link href="{{ asset('/css//buttons.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')

    {{--Header page --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="alert gray-nav">Rozszerzony Raport Kampanii</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="row">
                    <div class="col-lg-12">
                            <div class="panel-body">
                                <div class="form-group" style="margin-left: 1em;">
                                    <label for="date" class="myLabel">Data początkowa:</label>
                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="datak" style="width:50%;">
                                        <input class="form-control" name="date_start" id="date_start" type="text" value="{{date("Y-m-d")}}">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                </div>
                                <div class="form-group"style="margin-left: 1em;">
                                    <label for="date_stop" class="myLabel">Data końcowa:</label>
                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="datak" style="width:50%;">
                                        <input class="form-control" name="date_stop" id="date_stop" type="text" value="{{date("Y-m-d")}}">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Mediana wykorzystania bazy</span>
                                        <input id="mediana" type="text" class="form-control" name="mediana" placeholder="Wartość miediany" disabled>
                                    </div>
                                </div>
                                <div>
                                    <table id="datatable" class="thead-inverse table row-border table-striped" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Nazwa</th>
                                            <th>Data Ostatniej Aktualizacji</th>
                                            <th>Średnia</th>
                                            <th>Umówienia</th>
                                            <th>Wykorzystanie bazy</th>
                                            <th>Odebrane połączenia</th>
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
    <script src="https://cdn.datatables.net/scroller/1.5.0/js/dataTables.scroller.min.js"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('/js/jszip.min.js')}}"></script>
    <script src="{{ asset('/js/buttons.html5.min.js')}}"></script>
    <script>


        function getMedian(args) {
            if (!args.length) {return 0};
            var numbers = args.slice(0).sort((a,b) => a - b);
            var middle = Math.floor(numbers.length / 2);
            var isEven = numbers.length % 2 === 0;
            return isEven ? (numbers[middle] + numbers[middle - 1]) / 2 : numbers[middle];
        }
        document.addEventListener('DOMContentLoaded', function(mainEvent) {

            $('.form_date').datetimepicker({
                language:  'pl',
                autoclose: 1,
                minView : 2,
                pickTime: false,
            });
            var arrayOfResault = [];
            table = $('#datatable').DataTable({
                paginate: false,
                "autoWidth": true,
                "processing": true,
                "serverSide": true,
                "drawCallback": function( settings ) {

                },
                dom: 'Bfrtip',
                buttons: [
                    'excel',
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    arrayOfResault = [];
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {

                            if(typeof(b) != "undefined"){
                                let secondVal = b.split(" ");
                                secondVal = parseFloat(secondVal[0]);
                                if(secondVal!=0) arrayOfResault.push(parseFloat(secondVal));
                            }
                            // if(a != null || b != nu)
                            // let fistVal = a.split(" ");
                            // fistVal = fistVal[0];
                            // let secondVal = b.split(" ");
                            // secondVal = secondVal[0];
                            // return fistVal + secondVal;
                        }, 0 );
                    console.log( getMedian(arrayOfResault));
                    $('#mediana').val(getMedian(arrayOfResault));
                },
                "rowCallback": function( row, data, index ) {

                },"fnDrawCallback": function(settings) {

                },"ajax": {
                    'url': "{{route('api.pbxReportDetailedAjax')}}",
                    'type': 'POST',
                    'data': function (d) {
                        d.dateStart = $("#date_start").val();
                        d.dateStop = $('#date_stop').val();
                    },
                    'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Polish.json"
                },
                "columns":[
                    {"data":function (data, type, dataToSet) {
                            return data.name;
                        },"name":"name"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.date;
                        },"name":"date"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.average;
                        },"name":"average"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.success;
                        },"name":"success"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.database_use+" %";
                        },"name":"database_use"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.received_calls;
                        },"name":"received_calls"
                    }
                ]
            });
            resizeDatatablesOnMenuToggle([table]);
        });

        $('#date_start, #date_stop').on('change', function(e) {
           table.ajax.reload();
        });



    </script>
@endsection
