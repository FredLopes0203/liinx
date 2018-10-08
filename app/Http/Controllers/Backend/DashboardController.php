<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Tile;
use Illuminate\Http\Request;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(access()->hasRole(2))
        {
            if(access()->user()->organization == 0)
            {
                return redirect()->route('admin.group.index');
            }
        }

        $orgID = access()->user()->organization;

        $tileInfos = Tile::where('organization', $orgID)->get();

        foreach ($tileInfos as $tileInfo)
        {
            $creatorid = $tileInfo->userid;
            $creatorInfo = User::where('id', $creatorid)->first();
            $tileInfo['creatorName'] = "";
            if($creatorInfo != null)
            {
                $tileInfo['creatorName'] = $creatorInfo->full_name;
            }
        }

        return view('backend.dashboard.dashboard')->with(['tileInfos' => $tileInfos]);
    }

    public function adminindex()
    {
        if(access()->hasRole(2))
        {
            if(access()->user()->organization == 0)
            {
                return redirect()->route('admin.group.index');
            }
        }
        return redirect()->route('admin.dashboard');
    }

    public function viewposts($tileid, Request $request)
    {
        $tileInfo = Tile::where('id', $tileid)->first();
        return view('backend.dashboard.viewposts')->with(['tileInfo' => $tileInfo]);
    }
}
