<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Team;

class PlayerController extends Controller {

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
    public function index($id) {
        return view('player.index', ['id' => $id]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData($id) {

        $query = Player::where('team_id', $id);

        return DataTables::of($query)
                        ->editColumn('image_uri', function ($item) {
                            if ($item->logo_uri) {
                                return '<img src="' . $item->logo_uri . '" class="item-image">';
                            } else {
                                return '';
                            }
                        })
                        ->editColumn('created_at', function ($order) {
                            return Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('M d, Y');
                        })
                        ->editColumn('updated_at', function ($order) {
                            return Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at)->format('M d, Y');
                        })->rawColumns(['image_uri'])
                        ->make(true);
    }

    /**
     * Show the create team form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $teams = Team::where('user_id', auth()->user()->id)->get();
        return view('player.create', ['teams' => $teams, 'id' => $id]);
    }

    /**
     * Create a new player
     *
     * @param  Request  $request
     * @return veiw
     */
    public function store($id, Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
                    'team_id' => 'required|exists:teams,id',
                    'first_name' => 'required|max:25',
                    'last_name' => 'required|max:25',
                    'image_uri' => 'mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if (isset($input['team_id'])) {
            $id = $input['team_id'];
        }
        if ($validator->fails()) {
            return redirect("teams/$id/players/create")
                            ->withErrors($validator)
                            ->withInput();
        }

        $player = new Player();
        $player->first_name = $input['first_name'];
        $player->last_name = $input['last_name'];
        $player->user_id = auth()->user()->id;
        $player->team_id = $input['team_id'];
        $image = $request->file('image_uri');
        if (!empty($image)) {
            $logo_uri = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images/players');
            $image->move($path, $logo_uri);
            $player->image_uri = $logo_uri;
        }

        $player->save();
        return redirect('teams/' . $input['team_id'] . '/players')->with('message', 'Player added successfully!');
    }

}
