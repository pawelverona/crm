@extends('layouts.main')
@section('content')

{{--Header page --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <div class="alert gray-nav">Tygodniowy Raport Szkoleń</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{URL::to('/pageWeekReportTrainingGroup')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="date" class="myLabel">Data początkowa:</label>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="datak" style="width:50%;">
                        <input class="form-control" name="date_start" id="date" type="text" value="{{isset($date_start) ? $date_start :date("Y-m-d")}}">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date_stop" class="myLabel">Data końcowa:</label>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="datak" style="width:50%;">
                        <input class="form-control" name="date_stop" id="date_stop" type="text" value="{{isset($date_stop) ? $date_stop :date("Y-m-d")}}">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-info form-control" value="Generuj" style="width:50%;">
                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="start_stop">
                                <div class="panel-body">
                                        @include('mail.recruitmentMail.weekReportRecruitmentTrainingGroup')
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
    $('.form_date').datetimepicker({
        language:  'pl',
        autoclose: 1,
        minView : 2,
        pickTime: false,
    });
</script>
@endsection
