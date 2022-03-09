@extends('layouts.app')
<style type="text/css">
    .icon-calendar22:before{content:"\e99c";}
</style>
@section('content')
@include('errors.list')
@include('errors.sucess_list')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add Events </div>
                <div class="card-body">
                    <form action="{{url('/add_events')}}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Event Name</label>
                                <div class="col-sm-6">
                                    <input type="text" id="event_name" name="event_name" class="form-control" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Start Date</label>
                                <div class="col-sm-6">
                                    <input type="date" id="start" value="{{$today}}" class="form-control" name="start" min="{{$today}}">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">End Date</label>
                                <div class="col-sm-6">
                                    <input type="date" id="start" value="{{$today}}" class="form-control" name="end" min="{{$today}}">
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 text-center">
                                <button class="btn btn-success" tabindex="4" name="add_amount" id="add_amount" type="submit" value="Add Events"> Add event</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Events </div>
                <div class="card-body">
                    <form action="{{URL::to('create_event')}}" method="get">
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
                        <table class="table table-invoice" id="event_table">
                        <thead>
                            <th>No</th>
                            <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($events as $key=>$item)
                        <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->event_name}}</td>
                        <td>{{ date('d M Y',strtotime($item->start))}}</td>
                        <td>{{ date('d M Y',strtotime($item->end))}}</td>
                        <td class="d-flex">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Invite{{$item->id}}"> Invite </button>
                            <form action="{{ url('invite')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="event_id" value="{{ $item->id }}">
                                <div class="modal fade" id="Invite{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Enter Mail</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>&nbsp<button type="button" class="btn btn-info" data-toggle="modal" data-target="#show{{$item->id}}"> Invited users </button>
                            <div class="modal fade" id="show{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Invited Mails</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if(count($item->invited_users) > 0)
                                            @foreach($item->invited_users as $key=>$invited)
                                            <p>{{$invited->email}} </p>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

