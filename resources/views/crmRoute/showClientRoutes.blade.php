@extends('layouts.main')
@section('style')

@endsection
@section('content')

    <style>
        .check {
            background: #B0BED9 !important;
        }
    </style>

{{--Header page --}}
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <div class="alert gray-nav ">Podgląd Tras</div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   Wybierz trasę
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="showAllClients">Pokaż wszystkich klientów</label>
                                <input type="checkbox" style="display:inline-block" id="showAllClients">
                            </div>
                            <table id="datatable" class="thead-inverse table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Nazwa Klienta</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="showOnlyAssigned">Pokaż tylko trasy bez przypisanego hotelu lub godziny</label>
                                <input type="checkbox" style="display:inline-block" id="showOnlyAssigned">
                            </div>

                            <div class="form-group" style="margin-top:1em;">
                                <label for="year">Wybierz rok</label>
                                <select id="year" class="form-control">
                                    <option value="0">Wybierz</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-top:1em;">
                                <label for="weekNumber">Wybierz tydzień</label>
                                <select id="weekNumber" class="form-control">
                                    <option value="0">Wybierz</option>
                                </select>
                            </div>
                            <table id="datatable2" class="thead-inverse table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Tydzień</th>
                                    <th>Klient</th>
                                    <th>Data &Iukcy; pokazu</th>
                                    <th>Trasa</th>
                                    <th>Przypisany hotel i godziny</th>
                                    <th>Akceptuj trasę</th>
                                    <th>Edycja (Hoteli i godzin)</th>
                                    <th>Edycja (Trasy)</th>
                                    <th>Edycja parametrów (Kampanii)</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button id="addNewClientRoute" class="btn btn-info">Przejdź do przypisywania tras klientom</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Open modal
    </button>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Parametry Kampani</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="routes-container">
                        <div id="insertModalHere">

                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                    <div class="col-md-12">
                        <button type="button" class="btn btn-success"  style="width: 100%" id="saveCampaingOption">Zapisz</button>
                    </div>
                    <br>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {

            let yearInput = document.querySelector('#year');

            //This part is responsible for listing every week number into select
            const lastWeekOfYear ={{$lastWeek}};
            const weekSelect = document.querySelector('#weekNumber');
            for(var i = 1; i <= lastWeekOfYear ; i++) {
                let optionElement = document.createElement('option');
                optionElement.value = i;
                optionElement.innerHTML = `${i}`;
                weekSelect.appendChild(optionElement);
            }

            //this part is responsible for redirect button
            const addNewClientRouteInput = document.querySelector('#addNewClientRoute');
            addNewClientRouteInput.addEventListener('click',(e) => {
                window.location.href = '{{URL::to('/crmRoute_index')}}';
            });


            const showOnlyAssignedInput = document.querySelector('#showOnlyAssigned');
            const showAllClientsInput = document.querySelector('#showAllClients');
            const selectedWeekInput = document.querySelector('#weekNumber');
            let id = null; //after user click on 1st table row, it assing clientRouteId to this variable
            let selectedWeek = 0;
            let rowIterator = null;
            // let colorIterator = 0;
            let showAllClients = null; //this variable indices whether checkbox "Pokaż wszystkich klientó" is checked
            let showOnlyAssigned = null; //This variable indices whether checkbox "Pokaż tylko trasy bez przypisanego hotelu lub godziny" is checked
            // let colorArr = ['#e1e4ea', '#81a3ef', '#5a87ed', '#b2f4b8', '#6ee578', '#e1acef', '#c54ae8'];
            let objectArr = [];
            function createModalContent(response,placeToAppend){
                let departmentsJson = @json($departments);
                let routeContainer = document.createElement('div');
                routeContainer.className = 'campain-container';
                var content = '';
                console.log(response);
                for(var i = 0; i < response.length; i++){
                    content += '<div class="row">\n' +
                        '                            <div class="col-lg-12">\n' +
                        '                                <div class="panel panel-default">\n' +
                        '                                    <div class="panel-heading">\n' +
                        '                                        Pokaz Dzień : ' +response[i][0].date +
                        '                                    </div>\n' +
                        '                                    <div class="panel-body">\n' +
                        '                                        <div class="row">\n' +
                        '                                            <table class="table table-striped thead-inverse table-bordered">\n' +
                        '                                                <thead>\n' +
                        '                                                <th>Tydzień</th>\n' +
                        '                                                <th>Data</th>\n' +
                        '                                                <th>Godzina</th>\n' +
                        '                                                <th>Województwo</th>\n' +
                        '                                                <th>Miasto</th>\n' +
                        '                                                <th>Hotel</th>\n' +
                        '                                                <th>Oddział</th>\n' +
                        '                                                <th style="width: 10%">Limit</th>\n' +
                        '                                                <tbody>\n';

                    for(var j = 0; j < response[i].length; j++){
                        let hotel_name = "Brak";
                        if(response[i][j].hotel_info != null){
                            hotel_name = response[i][j].hotel_info.name;
                        }
                content += '                                                <tr class="campainsOption" id="routeInfoId_'+response[i][j].id+'">\n' +
                            '                                                    <td>'+response[i][j].weekNumber+'</td>\n' +
                            '                                                    <td>'+response[i][j].date+'</td>\n' +
                            '                                                    <td>'+response[i][j].hour+'</td>\n' +
                            '                                                    <td>'+response[i][j].voivodeName+'</td>\n' +
                            '                                                    <td>'+response[i][j].cityName+'</td>\n' +
                            '                                                    <td>'+hotel_name +'</td>\n' +
                            '                                                    <td class="optionDepartment">\n' +
                            '                                                        <select class="form-control">\n';
                                                                                        for(var item in departmentsJson){
                                                                                            content += '<option>'+departmentsJson[item].department_name+' '+departmentsJson[item].type_name+'</option>\n';
                                                                                        }
                                                                                content +=' </select>\n' +
                            '                                                    </td>\n' +
                            '                                                    <td class="optionLimit"><input class="form-control" type="number"></td>\n' +
                            '                                                </tr>\n';
                    }
                    content += '                                                </tbody>\n' +
                        '                                            </table>\n' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                            </div>\n' +
                        '                        </div>';
                }




                routeContainer.innerHTML = content;
                placeToAppend.appendChild(routeContainer);
            }
            table = $('#datatable').DataTable({
                "autoWidth": true,
                "processing": true,
                "serverSide": true,
                "drawCallback": function( settings ) {
                },
                "rowCallback": function( row, data, index ) {
                    $(row).attr('id', "client_" + data.id);
                    return row;
                },"fnDrawCallback": function(settings) {
                        $('table tbody tr').on('click', function() {
                            if(showAllClients === true) { //all clients checkbox = true + selecting one client
                                showAllClientsInput.checked = false;
                                showAllClients = false;
                            }
                            test = $(this).closest('table');
                            if($(this).hasClass('check')) {
                                $(this).removeClass('check');
                                id = null;
                            }
                            else {
                                test.find('tr.check').removeClass('check');
                                $.each(test.find('.checkbox_info'), function (item, val) {
                                    $(val).prop('checked', false);
                                });
                                $(this).addClass('check');
                                id = $(this).attr('id');
                                indexOfUnderscore = id.lastIndexOf('_');
                                id = id.substr(indexOfUnderscore + 1);
                            }
                            rowIterator = null;
                            // colorIterator = 0;
                            objectArr = [];
                            // showAllClients = null; //remove effect of show all clients checkbox
                            table2.ajax.reload();
                        })
                },"ajax": {
                    'url': "{{route('api.getClientRoutes')}}",
                    'type': 'POST',
                    'data': function (d) {
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
                    }
                ]
            });



            table2 = $('#datatable2').DataTable({
                "autoWidth": true,
                "processing": true,
                "serverSide": true,
                "fnDrawCallback": function(settings) {
                    objectArr = [];
                    const buttons = document.querySelectorAll('.action-buttons-0');
                    buttons.forEach(btn => {
                        btn.addEventListener('click', actionButtonHandler);
                    });
                    const buttons2 = document.querySelectorAll('.action-buttons-1');
                    buttons2.forEach(btn => {
                        btn.addEventListener('click', actionButtonHandlerAccepted);
                    });
                    $('.show-modal-with-data').on('click',function (e) {
                        let selectTR = e.currentTarget.parentNode.parentNode;
                        let routeId = $(selectTR).closest('tr').prop('id');
                        routeId = routeId.split('_');
                        routeId = routeId[1];
                        $.ajax({
                            type: "POST",
                            url: '{{ route('api.getReadyRoute') }}',
                            data: {
                                "route_id": routeId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                let placeToAppend = document.querySelector('#insertModalHere');
                                placeToAppend.innerHTML = '';
                                createModalContent(response,placeToAppend);
                                $('#myModal').modal('show');
                            }
                        });
                    });
                },
                "rowCallback": function( row, data, index ) {
                    if(row.cells[5].firstChild.classList[2] == "action-buttons-0") {
                        row.style.backgroundColor = "#ffc6c6";
                    }
                    else {
                        row.style.backgroundColor = "#d1fcd7";
                    }
                    $(row).attr('id', "clientRouteInfoId_" + data.clientRouteId);
                    return row;
                },
                "ajax": {
                    'url': "{{route('api.getClientRouteInfo')}}",
                    'type': 'POST',
                    'data': function (d) {
                        d.id = id;
                        d.showAllClients = showAllClients;
                        d.showOnlyAssigned = showOnlyAssigned;
                        d.selectedWeek = selectedWeek;
                        d.year = yearInput.value;
                    },
                    'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Polish.json"
                },
                "columns":[
                    {"data":function (data, type, dataToSet) {
                            return data.weekOfYear;
                        },"name":"weekOfYear"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.clientName;
                        },"name":"clientName"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.minDate;
                        },"name":"minDate"
                    },
                    {"data":function (data, type, dataToSet) {
                            return data.clientRouteName;
                        },"name":"clientRouteName"
                    },
                    {"data":function (data, type, dataToSet) {
                            if(data.haveHotel != '0' && data.hour != 'nie') {
                                return '<span style="color: darkgreen;">Tak</span>';
                            }
                            else {
                                return '<span style="color: red;">Nie</span>';
                            }
                        },"name":"hotelName"
                    },
                    {"data":function (data, type, dataToSet) {
                        if(data.status == 0) {
                            return '<button data-clientRouteId="' + data.clientRouteId + '" class="btn btn-success action-buttons-0" style="width:100%">Akceptuj</button>';
                        }
                        else {
                            return '<button data-clientRouteId="' + data.clientRouteId + '" class="btn btn-warning action-buttons-1" style="width:100%">Trasa nie gotowa</button>';
                        }

                        },"name":"acceptRoute"
                    },
                    {"data":function (data, type, dataToSet) {
                            return '<a href="{{URL::to("/specificRoute")}}/' + data.clientRouteId + '"><span style="font-size: 2.1em;" class="glyphicon glyphicon-edit"></span></a>';
                        },"name":"link"
                    },
                    {"data":function (data, type, dataToSet) {
                            return '<a href="{{URL::to("/specificRouteEdit")}}/' + data.clientRouteId + '"><span style="font-size: 2.1em;" class="glyphicon glyphicon-edit"></span></a>';
                        },"name":"link"
                    },
                    {"data":function (data, type, dataToSet) {
                            return '<span style="font-size: 2.1em;" class="glyphicon glyphicon-edit show-modal-with-data" data-route_id ="'+data.clientRouteId+'" ></span>';
                        },"name":"link"

                    }
                ]
            });

            function showAllClientsInputHandler(e) {
                const checkedRow = document.querySelector('.check');
                // console.assert(checkedRow, "Brak podswietlonego wiersza");
                if(checkedRow) { //remove row higlight and reset id variable
                    checkedRow.classList.remove('check');
                    id = null;
                }

                if(e.target.checked === true) {
                    showAllClients = true;
                }
                else {
                    showAllClients = false;
                }
                table2.ajax.reload();
            }

            function showOnlyAssignedHandler(e) {
                if(e.target.checked === true) {
                    showOnlyAssigned = true;
                }
                else {
                    showOnlyAssigned = false;
                }
                table2.ajax.reload();
            }

            function selectedWeekHandler(e) {
                    selectedWeek = e.target.value;
                table2.ajax.reload();
            }

            function actionButtonHandler(e) {
                const clientRouteId = e.target.dataset.clientrouteid;
                const url =`{{URL::to('/showClientRoutesStatus')}}`;
                const ourHeaders = new Headers();
                ourHeaders.append('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                ourHeaders.set('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                const formData = new FormData();
                formData.append('clientRouteId', clientRouteId);
                formData.append('delete', '0');

                fetch(url, {
                    method: 'post',
                    headers: ourHeaders,
                    credentials: "same-origin",
                    body: formData
                }).then(resp => resp.json())
                    .then(resp => {
                        table2.ajax.reload();
                    })

            }

            function actionButtonHandlerAccepted(e) {
                const clientRouteId = e.target.dataset.clientrouteid;
                const url =`{{URL::to('/showClientRoutesStatus')}}`;
                const ourHeaders = new Headers();
                ourHeaders.append('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                // ourHeaders.set('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                const formData = new FormData();
                formData.append('clientRouteId', clientRouteId);
                formData.append('delete', '1');

                fetch(url, {
                    method: 'post',
                    headers: ourHeaders,
                    credentials: "same-origin",
                    body: formData
                }).then(resp => resp.json())
                    .then(resp => {
                        if(resp == 0) {
                            console.log("Operacja się nie powiodła");
                        }
                        table2.ajax.reload();
                    })
            }

            /**
             * @param e
             * This method append list of weeks in selected year to weekInput
             */
            function yearHandler(e) {
                const selectedYear = e.target.value;

                if(selectedYear > 0) {
                    //part responsible for sending to server info about selected year
                    const header = new Headers();
                    header.append('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

                    let data = new FormData();
                    data.append('year', selectedYear);

                    const url = '{{route('api.getWeeks')}}';

                    fetch(url, {
                        method: 'post',
                        headers: header,
                        credentials: "same-origin",
                        body: data
                    })
                        .then(response => response.json())
                        .then(response => {
                            console.log(response);
                            const weeksInYear = response;
                            selectedWeekInput.innerHTML = '';
                            const basicOptionElement = document.createElement('option');
                            basicOptionElement.value = 0;
                            basicOptionElement.textContent = 'Wybierz';
                            selectedWeekInput.appendChild(basicOptionElement);
                            for(let i = 1; i <= weeksInYear + 1; i++) { //we are iterating to weeksInYear+1 because we are getting week number for 30.12, and in 31.12 can be monday(additional week)
                                const optionElement = document.createElement('option');
                                optionElement.value = i;
                                optionElement.textContent = i;
                                selectedWeekInput.appendChild(optionElement);
                            }
                        })
                        .catch(err => console.log(err));
                    table2.ajax.reload();
                }

            }



            showAllClientsInput.addEventListener('change', showAllClientsInputHandler);
            showOnlyAssignedInput.addEventListener('change', showOnlyAssignedHandler);
            selectedWeekInput.addEventListener('change', selectedWeekHandler);

            yearInput.addEventListener('change', yearHandler);

        });
    </script>
@endsection
