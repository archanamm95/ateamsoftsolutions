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
                <div class="card-header">Average Counts</div>
                <div class="card-body">
                    <form action="{{URL::to('all_events')}}" method="get">
                        <input name="_token" type="hidden" value="{{csrf_token()}}">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form-label col-sm-3">
                                Avg Counts
                                </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <p>{{round($average_counts,2)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-invoice" id="event_table">
                        <thead>
                            <th>No</th>
                            <th>User full name</th>
                            <th>Average events </th>
                        </thead>
                        <tbody>
                        @if(count($users)>0)
                        @foreach($users as $key=>$item)
                        <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->name}} {{$item->last_name}}</td>
                        <td>{{round($item->avg,2)}}</td>
                        @endforeach
                        @endif
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
