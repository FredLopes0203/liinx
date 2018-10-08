<?php

namespace App\Repositories\Backend\Tile;

use App\Events\Backend\Group\GroupDeleted;
use App\Models\Access\User\User;
use App\Models\Group;
use App\Models\Tile;
use App\Notifications\Backend\Organization\OrganizationApproveChanged;
use App\Notifications\Backend\Organization\OrganizationDeleteChanged;
use App\Notifications\Backend\Organization\OrganizationStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRepository.
 */
class TileRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Tile::class;

    public function __construct()
    {

    }

    public function create(array $input)
    {
        $data = $input['data'];
        $tileName = $data['tilename'];
        $postOption = $data['optpost'];
        $userid = $input['userid'];
        $orgid = $input['orgid'];
        $photoUrl = $input['photourl'];

        $postOptVal = 0;

        if($postOption == "on")
        {
            $postOptVal = 1;
        }

        $this->checkTileNameIfExist($tileName);

        $tile = self::MODEL;
        $tile = new $tile;
        $tile->name = $tileName;
        $tile->organization = $orgid;
        $tile->userid = $userid;
        $tile->picture = $photoUrl;
        $tile->poston = $postOptVal;

        DB::transaction(function () use ($tile) {
            if ($tile->save()) {

            }
        });
        return $tile;
    }

    public function update(Model $tile, array $input)
    {
        $data = $input['data'];
        $tileName = $data['tilename'];
        $userid = $input['userid'];
        $orgid = $input['orgid'];
        $photoUrl = $input['photourl'];

        $postOption = $data['optpost'];

        $postOptVal = 0;

        if($postOption == "on")
        {
            $postOptVal = 1;
        }

        $this->checkTileNameIfAvailable($tile, $tileName);

        $tile->name = $tileName;
        $tile->organization = $orgid;
        $tile->userid = $userid;
        $tile->poston = $postOptVal;


        if($photoUrl != "" && $photoUrl != null)
        {
            $tile->picture = $photoUrl;
        }

        DB::transaction(function () use ($tile) {
            if ($tile->save()) {
            }
        });
        return $tile;
    }

    protected function checkTileNameIfAvailable($tile, $tileName)
    {
        $orgid = access()->user()->organization;
        if ($tile->name != $tileName)
        {
            if ($this->query()->where('name', '=', $tileName)->where('organization', $orgid)->first())
            {
                throw new GeneralException('Existing Tile Name used.');
            }
        }
    }

    protected function checkTileNameIfExist($input)
    {
        $orgid = access()->user()->organization;
        if($this->query()->where('name', $input)->where('organization', $orgid)->first())
        {
            throw new GeneralException('Existing Tile Name Used.');
        }
    }

    protected function checkGroupInitialAdmin($groupId)
    {
        $initialAdmin = User::where('organization', $groupId)->where('isinitial', 1)->first();
        if($initialAdmin == null)
        {
            return true;
        }
        return false;
    }

    public function delete(Tile $tile)
    {
        if ($tile->delete()) {
            return true;
        }
        throw new GeneralException('Error in removing tile.');
    }

    public function forceDelete(Group $organization)
    {
        if (is_null($organization->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.delete_first'));
        }

        DB::transaction(function () use ($organization) {
            if ($organization->forceDelete()) {
                $admins = User::where('organization', $organization->id)->where('isadmin', 1)->get();
                foreach ($admins as $admin)
                {
                    $admin->notify(new OrganizationDeleteChanged(2, $organization));
                }
                return true;
            }

            throw new GeneralException('Error in organization permanently deleting.');
        });
    }

    public function restore(Group $organization)
    {
        if (is_null($organization->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_restore'));
        }

        if ($organization->restore()) {

            $admins = User::where('organization', $organization->id)->where('isadmin', 1)->get();
            foreach ($admins as $admin)
            {
                $admin->notify(new OrganizationDeleteChanged(1, $organization));
            }
            return true;
        }

        throw new GeneralException('Error in organization restoring.');
    }

    public function mark(Group $group, $status)
    {
        $group->status = $status;

        if ($group->save()) {
            $admins = User::where('organization', $group->id)->where('isadmin', 1)->get();
            foreach ($admins as $admin)
            {
                $admin->notify(new OrganizationStatusChanged($status, $group));
            }
            return true;
        }

        throw new GeneralException('Organization Updating Error');
    }

    public function approve(Group $group, $approve)
    {
        $group->approved = $approve;

        if($approve == 1)
        {
            if($group->groupid == "" || $group->groupid == null)
            {
                $group->groupid = $this->generateRndString(5);
            }
        }

        if ($group->save()) {
            $admins = User::where('organization', $group->id)->where('isadmin', 1)->get();
            foreach ($admins as $admin)
            {
                $admin->notify(new OrganizationApproveChanged($approve, $group));
            }
            return true;
        }

        throw new GeneralException('Error in approval.');
    }

    public function getForDataTable($status = 1, $approve = 1, $trashed = false)
    {
        if ($trashed == 'true') {

            $groups = $this->query();
            $groups = $groups->onlyTrashed();

            return $groups;
        }
        else
        {
            if($status == 0)
            {
                $groups = $this->query()->where('status', $status)->orderby('created_at', 'ASC')->get();
            }
            else
            {
                $groups = $this->query()->where('status', $status)->where('approved', $approve)->orderby('created_at', 'ASC')->get();
            }
            return $groups;
        }
    }

    function generateRndString($length = 5) {
        $characters = '1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
