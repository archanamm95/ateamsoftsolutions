@extends('layouts.app')
<style type="text/css">
    .icon-calendar22:before{content:"\e99c";}
</style>
@section('content')
@include('errors.list')
@include('errors.sucess_list')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Events </div>
                <div class="card-body">
                    <form action="{{URL::to('all_events')}}" method="get">
                        <input name="_token" type="hidden" value="{{csrf_token()}}">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form-label col-sm-3">
                                Start Date
                                </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input autocomplete="off" class="form-control daterange-single" id="start" name="start" required="true" type="date" value="{{ date('01/01/Y') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label col-sm-3">
                                    End Date
                                </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                    <input autocomplete="off" class="form-control daterange-single" id="end" name="end" required="true" type="date" value="{{ date('m/t/Y') }}">
                                    </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-offset-6">
                            <button class="btn btn-primary" type="submit">
                                Get Events
                            </button>
                        </div>
                        </input>
                    </form>
                    <div class="table-responsive">
                        @if(isset($events))
                        <table class="table table-invoice" id="event_table">
                        <thead>
                            <th>No</th>
                            <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </thead>
                        <tbody>
                        @foreach($events as $key=>$item)
                        <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->event_name}}</td>
                        <td>{{ date('d M Y',strtotime($item->start))}}</td>
                        <td>{{ date('d M Y',strtotime($item->end))}}</td>
                        
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        {!! $events->render() !!}@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
