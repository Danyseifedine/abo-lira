<?php

namespace App\Http\Controllers\SuperAdmin\Privileges;

use App\Http\Controllers\BaseController;
use App\Navigation\SuperAdminPath;
use App\Services\Core\PermissionService;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class PermissionsController extends BaseController
{
    public function __construct(
        private PermissionService $permissionService
    ) {
        $this->middleware('permission:access-super-admin-permission')->only('index');
    }

    public function index()
    {
        $query = $this->permissionService->getBaseQuery();
        $config = $this->permissionService->getDataTableConfig();

        $permissions = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('permissions/Index'), [
            'permissions' => $permissions,
            'filters' => $this->getFilters(['role', 'created_from', 'created_to']),
            'roles' => Role::all(),
        ]);
    }
}
