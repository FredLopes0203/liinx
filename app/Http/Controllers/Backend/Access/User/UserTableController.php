<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use function foo\func;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Access\User\UserRepository;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;

/**
 * Class UserTableController.
 */
class UserTableController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageUserRequest $request)
    {
        return Datatables::of($this->users->getForDataTable($request->get('admin'), $request->get('status'), $request->get('approve'), $request->get('trashed')))
            ->escapeColumns(['email'])
            ->editColumn('confirmed', function ($user) {
                return $user->confirmed_label;
            })
            ->addColumn('organization', function($user){
                return $user->organization_label;
            })
            ->addColumn('type', function($user){
                return $user->type_label;
            })
            ->addColumn('roles', function ($user) {
                return $user->roles->count() ?
                    implode('<br/>', $user->roles->pluck('name')->toArray()) :
                trans('labels.general.none');
            })
            ->addColumn('actions', function ($user) {
                return $user->action_buttons;
            })
            ->setRowClass(function ($user) {
                return ! $user->isConfirmed() && config('access.users.requires_approval') ? 'danger' : '';
            })
            ->withTrashed()
            ->make(true);
    }
}
