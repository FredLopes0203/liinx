<?php

namespace App\Http\Controllers\Backend\Tile;

use App\Http\Controllers\Backend\MyClass\RndNum;
use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Tile;
use App\Repositories\Backend\Tile\TileRepository;
use Illuminate\Http\Request;

class TileController extends Controller
{
    protected $tiles;

    public function __construct(TileRepository $tileRepository)
    {
        $this->tiles = $tileRepository;
    }

    public function index(Request $request)
    {
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
        return view('backend.tile.index')->with(['tileInfos' => $tileInfos]);
    }

    public function create(Request $request)
    {
        return view('backend.tile.create');
    }

    public function edit($tileid, Request $request)
    {
        $tileInfo = Tile::where('id', $tileid)->first();
        return view('backend.tile.update')->with(['tileInfo' => $tileInfo]);
    }

    public function store(Request $request)
    {
        $curUser = access()->user();
        $curUserID = $curUser->id;
        $curOrgId = $curUser->organization;
        $imgNum = RndNum::generateRndString();
        $tileName = $request->input('tilename');
        $tileName = str_replace(' ', '', $tileName);

        $url = "";

        if ($request->hasFile('logo')) {
            $fileName = $tileName . '_' .$imgNum.'.png';

            $request->file('logo')->move(
                base_path() . '/public/img/tiles/'.$curOrgId.'/', $fileName
            );
            $url = 'img/tiles/'.$curOrgId.'/' . $fileName;
        }

        $this->tiles->create(
            [
                'data' => $request->only(
                    'tilename',
                    'optpost'
                ),
                'userid' => $curUserID,
                'orgid' => $curOrgId,
                'photourl' => $url
            ]);
        return redirect()->route('admin.tile.index')->withFlashSuccess('New tile was created successfully.');
    }

    public function update(Tile $tile, Request $request)
    {
        $tileName = $request->input('tilename');
        $curUser = access()->user();
        $curUserID = $curUser->id;
        $curOrgId = $curUser->organization;
        $tileName = str_replace(' ', '', $tileName);

        $url = "";
        $imgNum = RndNum::generateRndString();

        if ($request->hasFile('logo')) {
            $fileName = $tileName . '_' .$imgNum.'.png';

            $request->file('logo')->move(
                base_path() . '/public/img/tiles/'.$curOrgId.'/', $fileName
            );
            $url = 'img/tiles/'.$curOrgId.'/' . $fileName;
        }

        $this->tiles->update($tile,
            [
                'data' => $request->only(
                    'tilename',
                    'optpost'
                ),
                'userid' => $curUserID,
                'orgid' => $curOrgId,
                'photourl' => $url
            ]);

        return redirect()->route('admin.tile.index')->withFlashSuccess('Tile was updated successfully.');
    }

    public function destroy(Tile $tile, Request $request)
    {
        $this->tiles->delete($tile);
        return redirect()->route('admin.tile.index')->withFlashSuccess('Tile was removed successfully.');
    }
}
