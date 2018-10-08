<?php

namespace App\Http\Controllers\Backend\Accept;

use App\Http\Controllers\Backend\MyClass\RndNum;
use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Tile;
use App\Repositories\Backend\Tile\TileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcceptController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $orgID = access()->user()->organization;

        $tileInfos = Tile::where('organization', $orgID)->get();

        $firsttile = 0;
        $index = 0;
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

            $index = $index + 1;
            if($index == 2)
            {
                $tileInfo["requests"] = 5;
            }
            else if($index == 3)
            {
                $tileInfo["requests"] = 7;
            }
            else if($index == 4)
            {
                $tileInfo["requests"] = 2;
            }
            else
            {
                $tileInfo["requests"] = 8;
            }
        }

        return view('backend.accept.index')->with(['tileInfos' => $tileInfos, 'firsttile' => $firsttile]);
    }
}
