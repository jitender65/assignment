<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the team list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('team.index');
    }

    /**
     * Show the create team form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('team.create');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData() {
        $query = Team::where('user_id', auth()->user()->id);
        return DataTables::of($query)
                        ->editColumn('created_at', function ($order) {
                            return Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('M d, Y');
                        })
                        ->editColumn('updated_at', function ($order) {
                            return Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('M d, Y');
                        })
                        ->editColumn('name', function ($item) {
                            $url = url('/teams/' . $item->id . '/players');
                            return '<a href="' . $url . '">' . $item->name . '</a>';
                        })
                        ->editColumn('logo_uri', function ($item) {
                            if ($item->logo_uri) {
                                return '<img src="' . $item->logo_uri . '" class="item-image">';
                            } else {
                                return '';
                            }
                        })->rawColumns(['name', 'logo_uri'])
                        ->make(true);
    }

    /**
     * Create a new team
     *
     * @param  Request  $request
     * @return veiw
     */
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
                    'name' => 'required|max:50',
                    'logo_uri' => 'mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('teams/create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $team = new Team();
        $team->name = $input['name'];
        $team->user_id = auth()->user()->id;


        $image = $request->file('logo_uri');
        if (!empty($image)) {
            $logo_uri = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/teams');
            $image->move($path, $logo_uri);
            $team->logo_uri = $logo_uri;
        }

        $team->save();
        return redirect('teams')->with('message', 'Team added successfully!');
    }

}
