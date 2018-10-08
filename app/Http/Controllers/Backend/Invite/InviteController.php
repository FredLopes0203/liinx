<?php

namespace App\Http\Controllers\Backend\Invite;

use App\Http\Controllers\Backend\MyClass\RndNum;
use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Tile;
use App\Repositories\Backend\Tile\TileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InviteController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $orgID = access()->user()->organization;

        $tileInfos = Tile::where('organization', $orgID)->get();

        $firsttile = 0;
        foreach ($tileInfos as $tileInfo)
        {
            if($firsttile == 0)
            {
                $firsttile = $tileInfo->id;
            }

            $creatorid = $tileInfo->userid;
            $creatorInfo = User::where('id', $creatorid)->first();
            $tileInfo['creatorName'] = "";
            if($creatorInfo != null)
            {
                $tileInfo['creatorName'] = $creatorInfo->full_name;
            }
        }

        return view('backend.invite.index')->with(['tileInfos' => $tileInfos, 'firsttile' => $firsttile]);
    }

    public function getTileUsers(Request $request)
    {
        $tileId = $request->input('tileid');
        $searchName = $request->input('searchname');

        $curUser = access()->user();
        $curOrg = $curUser->organization;

        $users = User::where('organization', $curOrg)
            ->where('status', 1)
            ->where('approve', 1)
            ->where('confirmed', 1)
            //->where('first_name', 'like', '%'.$searchName.'%')
            ->where(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'like', '%'.$searchName.'%')
            ->get();

        return response()->json(['userInfos' => $users]);
    }
}
