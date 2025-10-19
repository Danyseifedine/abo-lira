<?php

namespace App\Http\Controllers\SuperAdmin\Privileges;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Navigation\SuperAdminPath;
use App\Services\Core\RoleService;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends BaseController
{
    public function __construct(
        private RoleService $roleService
    ) {
        $this->middleware('permission:access-super-admin-role')->only('index', 'show');
        $this->middleware('permission:create-super-admin-role')->only('create', 'store');
        $this->middleware('permission:update-super-admin-role')->only('edit', 'update');
        $this->middleware('permission:delete-super-admin-role')->only('destroy');
    }

    public function index()
    {
        $query = $this->roleService->getBaseQuery();
        $config = $this->roleService->getDataTableConfig();

        $roles = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('roles/Index'), [
            'roles' => $roles,
            'filters' => $this->getFilters(['created_from', 'created_to']),
        ]);
    }

    public function create()
    {
        return Inertia::render(SuperAdminPath::view('roles/actions/Create'), [
            'permissions' => Permission::all(),
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->create($request->all());

        return $this->successWithToast('Role created successfully', 'Success', 'super-admin.roles.index');
    }

    public function edit(Role $role)
    {
        $role->load('permissions');

        return Inertia::render(SuperAdminPath::view('roles/actions/Edit'), [
            'role' => $role,
            'permissions' => Permission::all(),
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleService->update($role, $request->all());

        return $this->successWithToast('Role updated successfully', 'Success', 'super-admin.roles.index');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return Inertia::render(SuperAdminPath::view('roles/actions/Show'), [
            'role' => $role,
        ]);
    }

    public function destroy(Role $role)
    {
        $this->roleService->delete($role);

        return $this->successWithToast('Role deleted successfully', 'Success', 'super-admin.roles.index');
    }
}
