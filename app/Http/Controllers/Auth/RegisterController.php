<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Event;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gender' => ['required'],
            'dob' => ['before:18 years ago'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'dateofbirth' => $data['dob'],
        ]);
    }

    protected function all_events(Request $request)
    {
        $title     = "All Events";
        $sub_title = "All Events";
        $base      = "All Events";
        $method    = "All Events";
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
        $events = Event::where('start', '>=', date('Y-m-d 00:00:00', strtotime($start)))->where('end', '<', date('Y-m-d 23:59:59', strtotime($end)))->paginate(10);

        return view('auth.all_events', compact('title','base','method','sub_title','today','events'));
    }
    protected function average_counts(Request $request)
    {
        $title     = "Average Counts";
        $sub_title = "Average Counts";
        $base      = "Average Counts";
        $method    = "Average Counts";
        $total_events = count(Event::get());
        $users = User::get();
        $total_users = count($users);
        $average_counts = $total_events/$total_users;
        foreach ($users as $key => $value) {
            $user_events = Event::where('user_id',$value->id)->count();
            $value->avg = $user_events/$total_events;
        }
        return view('auth.average_counts', compact('title','base','method','sub_title','average_counts','users'));
    }
}
