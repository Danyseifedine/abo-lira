<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Navigation\SuperAdminPath;
use App\Models\User;
use App\Services\Core\UserService;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UsersController extends BaseController
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index()
    {
        $query = $this->userService->getBaseQuery();
        $config = $this->userService->getDataTableConfig();

        $users = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view("users/Index"), [
            'users' => $users,
            'filters' => $this->getFilters(['role', 'status', 'email_verified', 'created_from', 'created_to']),
            'roles' => Role::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render(SuperAdminPath::view("users/actions/Create"), [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create($request->all());
        return $this->successWithToast('User created successfully', 'Success', 'super-admin.users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render(SuperAdminPath::view("users/actions/Edit"), [
            'user' => $user,
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->all());
        return $this->successWithToast('User updated successfully', 'Success', 'super-admin.users.index');
    }

    public function show(User $user)
    {
        return Inertia::render(SuperAdminPath::view("users/actions/Show"), [
            'user' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user);
        return $this->successWithToast('User deleted successfully', 'Success', 'super-admin.users.index');
    }


    public function toggleStatus(User $user)
    {
        try {
            $this->userService->toggleStatus($user);

            $status = $user->is_active ? 'activated' : 'deactivated';
            $message = "User '{$user->name}' has been {$status} successfully.";

            return $this->successWithToast($message, 'User ' . ucfirst($status));
        } catch (\Exception $e) {
            return $this->errorWithToast('Failed to update user status. Please try again.');
        }
    }
}
