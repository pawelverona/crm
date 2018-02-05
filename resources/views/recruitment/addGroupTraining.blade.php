@extends('layouts.main')
@section('content')
    <style>
        .myLabel {
            color: #aaa;
            font-size: 20px;
        }
        .left-container{
            height: 300px;
            overflow-y: auto;
            border: 1px solid #e5e5e5;
        }
        .right-container{
            height: 300px;
            overflow-y: auto;
            border: 1px solid #e5e5e5;
        }
        .list-group{
            padding-left: 0;
            margin-bottom: 20px;
        }
        .list-group-item{
            position: relative;
            display: block;
            padding: 10px 15px;
            margin-bottom: -1px;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        a.list-group-item:hover, a.list-group-item:focus {
            color: #555 !important;
            text-decoration: none !important;
            background-color: #f5f5f5 !important;
        }
        a.check:hover, a.check:focus{
            color: #fff !important;
            background-color: #3470ae !important;
            border-color: #2d659c !important;
        }
        .list-group-item:first-child {
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        .pull-right{
            float: right!important;
        }
        .pull-left{
            float: right!important;
        }
        .search_candidate{
            margin-bottom: 15px;
        }
        .check{
            color: #fff !important;
            background-color: #337ab7;
            border-color: #2e6da4;
        }

        #button_move_area{
            margin-top: 150px;
        }

    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <div class="well gray-nav">Rekrutacja / Dział Szkoleń</div>
            </div>
        </div>
    </div>

    <button data-toggle="modal" class="btn btn-default training_to_modal" data-target="#myModalgroup" data-category_id="{{1}}" title="Dodaj szkolenie" style="margin-bottom: 14px">
        <span class="glyphicon glyphicon-plus"></span> <span>Dodaj szkolenie</span>
    </button>

    <div id="myModalgroup" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="width: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ustalanie szkolenia<span id="modal_category"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="myLabel">Data:</label>
                                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="datak" style="width:100%;">
                                        <input class="form-control" name="start_date_training" type="text" value="{{date("Y-m-d")}}" readonly />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="myLabel">Godzina:</label>
                                    <div class="input-group date form_time" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
                                        <input id="start_time_training" class="form-control" size="16" type="text" value="" readonly/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="myLabel">Prowadzący:</label>
                                    <select class="form-control" id="id_user">
                                        @foreach($cadre as $item)
                                            <option id={{$item->id}} value={{$item->id}} >{{$item->last_name.' '.$item->first_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="myLabel">Komentarz:</label>
                                    <textarea id="training_comment" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <label class="myLabel">Dostępni kandydaci:</label>
                                <div class="search_candidate">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="left_search" placeholder="Wyszukaj kandydata"/>
                                        <div class="input-group-addon">
                                            <input type="checkbox" id="all-put-left" style="display: block">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="left-container">
                                        <div class="list_group" id="list_candidate">
                                            <a class="list-group-item">
                                                Jan Kowalski
                                                <input type="checkbox" class="pull-left" style="display: block">
                                            </a>
                                            <a class="list-group-item checked">
                                                Jan Kowalski
                                                <input type="checkbox" class="pull-left" style="display: block">
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2" id="button_move_area">
                                <button id="move_right" class="btn btn-default center-block add" style="margin-bottom: 15px">
                                    <i class="glyphicon glyphicon-chevron-right"></i>
                                </button>
                                <button id="move_left" class="btn btn-default center-block remove">
                                    <i class="glyphicon glyphicon-chevron-left"></i>
                                </button>
                            </div>
                            <div class="col-md-5">
                                <label class="myLabel">Osoby na szkolenie:</label>
                                <div class="search_candidate">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="right_search" placeholder="Wyszukaj osobe na szkoleniu"/>
                                        <div class="input-group-addon">
                                            <input type="checkbox" class="all-put-right" style="display: block">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="right-container">
                                        <div class="list_group" id="list_candidate_choice">

                                            <a class="list-group-item checked">
                                                Jan Kowalski
                                                <input type="checkbox" class="pull-left" style="display: block">
                                            </a>
                                            <a class="list-group-item">
                                                Jan Kowalski
                                                <input type="checkbox" class="pull-left" style="display: block">
                                            </a>
                                            <a class="list-group-item">
                                                Jan Kowalski
                                                <input type="checkbox" class="pull-left" style="display: block">
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="save_button">Dodaj szkolenie</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista szkoleń
                </div>
                <div class="alert alert-success" style = "display:none" id="succes_add_training">
                    <span colspan="1">Szkolenie zostało dodane</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <ul class="nav nav-tabs" style="margin-bottom: 25px">
                            <li class="active"><a data-toggle="tab" href="#home">Dostępne</a></li>
                            <li><a data-toggle="tab" href="#menu1">Zakończone</a></li>
                            <li><a data-toggle="tab" href="#menu2">Anulowane</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <row>
                                            <table id="activ_training_group" class="table thead-inverse table-striped table-bordered" cellspacing="0" width="100%" >
                                                <thead>
                                                <tr>
                                                    <td>Data</td>
                                                    <td>Godzina</td>
                                                    <td>Liczba osób</td>
                                                    <td>Akcja</td>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </row>
                                    </div>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <row>
                                            <table id="end_training_group" class="table thead-inverse table-striped table-bordered" cellspacing="0" width="100%" >
                                                <thead>
                                                <tr>
                                                    <td>Data</td>
                                                    <td>Godzina</td>
                                                    <td>Liczba osób</td>
                                                    <td>Akcja</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </row>
                                    </div>
                                </div>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <row>
                                            <table id="cancel_training_group" class="table thead-inverse table-striped table-bordered" cellspacing="0" width="100%" >
                                                <thead>
                                                <tr>
                                                    <td>Data</td>
                                                    <td>Godzina</td>
                                                    <td>Liczba osób</td>
                                                    <td>Akcja</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </row>
                                    </div>
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
    <script>
        var candidate_to_left = [];
        var candidate_to_right = [];
        var id_training_group = 0;
        var training_group_response;
        var is_open = 0;
        var saving_type = 1; // 1 - nowy wpis, 0 - edycja
        var action_row =
            '<a class="btn btn-default info_active" href="#">'+
            '<span style="color: green" class="glyphicon glyphicon glyphicon-info-sign"></span> Szczegóły'+
            '</a>'+
            '<a class="btn btn-default end_active" href="#">'+
            '<span style="color: green" class="glyphicon glyphicon glyphicon-pencil"></span> Zakończ'+
            '</a>'+
            '<a class="btn btn-default cancle_active" data-id ={{1}} href="#">'+
            '<span style="color: green" class="glyphicon glyphicon glyphicon-trash"></span> Anuluj'+
            '</a>';

        var action_row_end_cancel =
            '<a class="btn btn-default info_active" href="#">'+
            '<span style="color: green" class="glyphicon glyphicon glyphicon-info-sign"></span> Szczegóły'+
            '</a>';


        function onclickRowLeft(e)
        {
            var candidate_id = e.id;
            var a_row = $('#'+candidate_id);
            var class_name = a_row.attr('class');
            var candidate_name = a_row.text();
            class_name = class_name.split(" ");

            //zaznaczony kandydat do szkolenia
            if(class_name[1] == 'nocheck'){
                a_row.find('[type=checkbox]').prop('checked', true);
                a_row.removeClass('nocheck');
                a_row.addClass('check');
                // wpisanie kandydata do tablicy
                candidate_to_right.push({id:candidate_id,name:candidate_name});
            }else{ // zaznaczony kandydat do usuniecie ze szkolenia
                a_row.find('[type=checkbox]').prop('checked', false);
                a_row.removeClass('check');
                a_row.addClass('nocheck');
                // usunięcie z tablicy
                removeFunction(candidate_to_right,"id",candidate_id);
            }
        }
        function onclickRowRight(e)
        {
            // id kandydata
            var candidate_id = e.id;
            //pobranie wirsza z po id kandydata
            var a_row = $('#'+candidate_id);
            // wysłuskanie nazwy klasy(czy jest zaznaczona czy nie)
            var class_name = a_row.attr('class');
            var candidate_name = a_row.text();
            class_name = class_name.split(" ");

            //zaznaczony kandydat do szkolenia (dodanie odpowiedniej klasy i wpisanie do tablicy
            // dzięki której będzie można przepisać z osobę z jednej tabeli do drugiej
            if(class_name[1] == 'nocheck'){
                a_row.find('[type=checkbox]').prop('checked', true);
                a_row.removeClass('nocheck');
                a_row.addClass('check');
                // wpisanie kandydata do tablicy
                candidate_to_left.push({id:candidate_id,name:candidate_name});
            }else{ // zaznaczony kandydat do usuniecie ze szkolenia ( odznaczenie)
                a_row.find('[type=checkbox]').prop('checked', false);
                a_row.removeClass('check');
                a_row.addClass('nocheck');
                // usunięcie z tablicy po id
                removeFunction(candidate_to_left,"id",candidate_id);
            }
        }

        // Funkcja do usuwania elementów z tablicy no indeksie
        function removeFunction (myObjects,prop,valu)
        {
            var what_delete = null;
            for(var i=0;i<myObjects.length;i++)
            {
                if(myObjects[i][prop] == valu)
                {
                    what_delete = i;
                    break;
                }
            }
            if(what_delete != null)
                myObjects.splice(what_delete,1);
            return myObjects;
        }



        $(document).ready(function() {
            $('.form_date').datetimepicker({
                language: 'pl',
                autoclose: 1,
                minView: 2,
                pickTime: false,
            });
            $('.form_time').datetimepicker({
                language:  'pl',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 1,
                minView: 0,
                maxView: 1,
                forceParse: 0
            });


            $('#save_button').on('click',function (e) {
                var start_date_training = $("input[name='start_date_training']").val();
                var start_hour_training = $("input[id='start_time_training']").val();
                var cadre_id = $("#id_user").val();
                var comment_about_training = $("#training_comment").val();
                var check_all = true;
                var avaible_candidate = [];
                var choice_candidate = [];
                if(start_hour_training.trim() == 0)
                {
                    swal("Nie wyznaczyłeś godziny szkolenia.")
                }else{
                    $("#save_button").attr('disabled', true);

                    // wszyscy kandydaci do wyboru
                    $('#list_candidate a').each(function (key, value) {
                        avaible_candidate.push(value.id) ;
                    });
                    // wyszycy kandydaci
                    $('#list_candidate_choice a').each(function (key, value) {
                        choice_candidate.push(value.id) ;
                    });

                    $.ajax({
                        type: "POST",
                        url: '{{ route('api.saveGroupTraining') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "start_date_training":start_date_training,
                            "start_hour_training":start_hour_training,
                            "cadre_id": cadre_id,
                            "comment_about_training":comment_about_training,
                            "avaible_candidate":avaible_candidate,
                            "choice_candidate":choice_candidate,
                            "saving_type":saving_type,
                            "id_training_group" : id_training_group
                        },
                        success: function (response) {
                            if(response == 1)
                            {
                                $('#myModalgroup').modal('hide');
                                $('#succes_add_training').fadeIn(1000);
                                $('#succes_add_training').delay(3000).fadeOut(1000);
                                $("#save_button").attr('disabled', false);
                                table_activ_training_group.ajax.reload();

                            }else if(response == 0){
                                swal('Wystąpił problem z zapise, skontaktuj się z administratorem !!')
                            }
                        }
                    });

                }
            });


            $('#all-put-left').on('change',function (e) {
                $('#list_candidate a').each(function (key, value) {

                });

            });
            // przeniesienie do prawej tabeli (wybrani użytkownicy)
            $('#move_right').on('click',function (e) {
                // kod html z tabelą
                var html_right_column = '';
                for(var i = 0;i < candidate_to_right.length; i++)
                {
                    html_right_column += '<a class="list-group-item nocheck" onclick = "onclickRowRight(this)" id=' + candidate_to_right[i].id + '>' +
                        candidate_to_right[i].name +
                        '<input type="checkbox" class="pull-right" style="display: block">' +
                        '</a>';
                    // usunięcie użytkownika z lewej tabeli
                    $('#'+candidate_to_right[i].id).remove();
                }
                $('#list_candidate_choice').append(html_right_column);
                candidate_to_right = [];
            });

            $('#move_left').on('click',function (e) { // analogiczne
                var html_left_column = '';
                for(var i = 0;i < candidate_to_left.length; i++)
                {
                    html_left_column += '<a class="list-group-item nocheck" onclick = "onclickRowLeft(this)" id=' + candidate_to_left[i].id + '>' +
                        candidate_to_left[i].name +
                        '<input type="checkbox" class="pull-left" style="display: block">' +
                        '</a>';
                    $('#'+candidate_to_left[i].id).remove();
                }
                $('#list_candidate').append(html_left_column);
                candidate_to_left = [];
            });
            // wyszukiwanie
            $("#left_search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".left-container .list_group a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // wyszukiwanie
            $("#right_search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".right-container .list_group a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // open modal
            $('#myModalgroup').on('show.bs.modal', function() {
                if(is_open == 0)
                {
                    if(saving_type == 1){
                        $("input[name='start_date_training']").val("{{date('Y-m-d')}}");
                    }
                    clearLeftColumn();
                    getGroupTrainingInfo();
                    is_open = 1;
                }
            });
            // Czyszczenie kolumn
            function clearLeftColumn()
            {
                candidate_to_right = [];
                candidate_to_left = [];
                $(".list_group a").remove();
            }
            // usuniecie podstawowych infromacji o szkoleniu
            function clearModalBasicInfo () {
                $("input[name='start_date_training']").val("");
                $("input[id='start_time_training']").val("");
                $("#id_user").prop("selectedIndex", 0);
                $("#training_comment").val("");
            }
            // pobranie danych o szkoleniu
            function getGroupTrainingInfo() {
                // gdy tworzone jest nowe szkolenie
                if(id_training_group == 0){
                    $.ajax({
                        type: "POST",
                        url: '{{ route('api.getCandidateForGroupTrainingInfo') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {},
                        success: function (response) {
                            if (response.length != 0) {
                                for (var i = 0; i < response.length; i++) {
                                    var html = '<a class="list-group-item nocheck" onclick = "onclickRowLeft(this)" id=' + response[i].id + '>' +
                                        response[i].first_name + ' ' + response[i].last_name +
                                        '<input type="checkbox" class="pull-left" style="display: block">' +
                                        '</a>';
                                    if (response[i].attempt_status_id == 5) {
                                        $('#list_candidate').append(html);
                                    }
                                }
                            }
                        }
                    });
                }// istniejące
                else if(id_training_group != 0 ) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('api.getGroupTrainingInfo') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "id_training_group": id_training_group
                        },
                        success: function (response) {
                            training_group_response = response;
                            console.log(response);
                            if (response.length != 0) {
                                for (var i = 0; i < response['group_training'].length; i++) {
                                    $("input[name='start_date_training']").val(response['group_training'][i].training_date);
                                    $("input[id='start_time_training']").val(response['group_training'][i].training_hour.slice(0, -3));
                                    $("#id_user").val(response['group_training'][i].leader_id);
                                    $("#training_comment").val(response['group_training'][i].comment);
                                }
                                for (var i = 0; i < response['candidate'].length; i++) {
                                    if (response['candidate'][i].attempt_status_id == 5) {
                                        var html = '<a class="list-group-item nocheck" onclick = "onclickRowLeft(this)" id=' + response['candidate'][i].id + '>' +
                                            response['candidate'][i].first_name + ' ' + response['candidate'][i].last_name +
                                            '<input type="checkbox" class="pull-left" style="display: block">' +
                                            '</a>';
                                        $('#list_candidate').append(html);
                                    } else if (response['candidate'][i].attempt_status_id == 6) {
                                        var html = '<a class="list-group-item nocheck" onclick = "onclickRowRight(this)" id=' + response['candidate'][i].id + '>' +
                                            response['candidate'][i].first_name + ' ' + response['candidate'][i].last_name +
                                            '<input type="checkbox" class="pull-right" style="display: block">' +
                                            '</a>';
                                        $('#list_candidate_choice').append(html);
                                    }
                                }
                            } else {

                            }
                        }
                    });
                }
            }
            //cancel modal
            $('#myModalgroup').on('hidden.bs.modal',function () {
                id_training_group = 0;
                clearModalBasicInfo();
                clearLeftColumn();
                is_open = 0;
                saving_type = 1;
            });
            //tabela dostępnych szkoleń
            var table_activ_training_group = $('#activ_training_group').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Polish.json"
                },"ajax": {
                    'url': "{{ route('api.datatableTrainingGroupList') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d.list_type = 1;
                    },
                    'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },
                "columns": [
                    {"data": "training_date"},
                    {"data": "training_hour"},
                    {"data": "candidate_count"},
                    {
                        "data": function (data, type, dataToSet) {
                            return action_row;
                        }
                    }
                ],"fnDrawCallback": function(settings){ // działanie po wyrenderowaniu widoku
                    // po kliknięcu w szczegóły otwórz modal z możliwością edycji
                    $('.info_active').on('click',function (e) {
                        saving_type = 0;
                        //główny wiersz
                        var tr = $(this).closest('tr');
                        id_training_group = tr.attr('id');
                        $('#myModalgroup').modal("show");
                    });
                },"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    // Dodanie id do wiersza
                    $(nRow).attr('id', aData.id);
                    return nRow;
                }
            });
            // tabela zakończonych szkoleń
            var table_end_training_group = $('#end_training_group').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Polish.json"
                },"ajax": {
                    'url': "{{ route('api.datatableTrainingGroupList') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d.list_type = 2;
                    },
                    'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },"columns": [
                    {"data": "training_date"},
                    {"data": "training_hour"},
                    {"data": "candidate_count"},
                    {
                        "data": function (data, type, dataToSet) {
                            return action_row_end_cancel;
                        }
                    }
                ]
            });
            // tabela skaswoanych szkoleń
            var table_cancel_training_group = $('#cancel_training_group').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Polish.json"
                },"ajax": {
                    'url': "{{ route('api.datatableTrainingGroupList') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d.list_type = 0;
                    },
                    'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },"columns": [
                    {"data": "training_date"},
                    {"data": "training_hour"},
                    {"data": "candidate_count"},
                    {
                        "data": function (data, type, dataToSet) {
                            return action_row_end_cancel;
                        }
                    }
                ]
            });


        });
    </script>
@endsection