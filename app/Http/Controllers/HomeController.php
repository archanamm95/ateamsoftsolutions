<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Event;
use App\Invite;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function create_event(Request $request)
    {
        $title     = "Add Events";
        $sub_title = "Add Events";
        $base      = "Add Events";
        $method    = "Add Events";
        $today = date('Y-m-d');
        $start =date('m/01/Y');
        $end   =date('m/t/Y');
        if($request->has('start')){ 
            $start = $request->start;
            $end = $request->end;
            $validator = Validator::make($request->all(), [
                'start'=>'required|before_or_equal:end',
                'end'=>'required|after_or_equal:start',   
            ]);
            if ($validator->fails()) {  
                return redirect()->back()->withErrors($validator);
            } 
        }  
        $events = Event::where('user_id',Auth::user()->id)->where('start', '>=', date('Y-m-d 00:00:00', strtotime($start)))->where('end', '<', date('Y-m-d 23:59:59', strtotime($end)))->get();
        foreach ($events as $key => $value) {
            $value->invited_users = Invite::where('event_id',$value->id)->get();
        }

        return view('app.add_events', compact('title','base','method','sub_title','today','events'));
    }

    public function add_events(Request $request){
        $validator = Validator::make($request->all(), [
            'event_name'    => 'required',
            'start'    => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors('The end date must be a date after or equal to when date.');
        }
        $event = new Event;
        $event->user_id = Auth::user()->id;
        $event->event_name = $request->event_name;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->save();
        return redirect('create_event')->with('success', 'Saved!');
    }
    public function invite(Request $request){
        $invite = new Invite;
        $invite->event_id = $request->event_id;
        $invite->email = $request->email;
        $invite->save();
        return redirect('create_event')->with('success', 'Saved!');
    }
}
