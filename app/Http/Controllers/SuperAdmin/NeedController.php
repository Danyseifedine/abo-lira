<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Models\Need;
use App\Navigation\SuperAdminPath;
use App\Services\Core\NeedService;
use Inertia\Inertia;

class NeedController extends BaseController
{
    public function __construct(
        private NeedService $needService
    ) {}

    public function index()
    {
        $query = $this->needService->getBaseQuery();
        $config = $this->needService->getDataTableConfig();

        $needs = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('needs/Index'), [
            'needs' => $needs,
            'filters' => $this->getFilters(['status', 'created_from', 'created_to']),
            'columnLabels' => __('datatable.needs_columns'),
        ]);
    }

    public function show(Need $need)
    {
        $need = $this->needService->findByIdOrFail($need->id);

        // Add image URL from request-image collection
        $need->image = $need->getFirstMediaUrl('request-image');

        return Inertia::render(SuperAdminPath::view('needs/Show'), [
            'need' => $need,
        ]);
    }

    public function destroy(Need $need)
    {
        $this->needService->delete($need);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.needs.index');
    }

    public function markAsRead(Need $need)
    {
        $this->needService->markAsRead($need);

        return redirect()->route('super-admin.needs.show', $need)->with([
            'success' => true,
            'toast' => [
                'type' => 'success',
                'title' => __('toast.success'),
                'message' => __('toast.marked_as_read'),
            ],
        ]);
    }
}
