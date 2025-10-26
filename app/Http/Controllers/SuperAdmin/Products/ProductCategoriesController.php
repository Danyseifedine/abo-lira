<?php

namespace App\Http\Controllers\SuperAdmin\Products;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductCategory\StoreProductCategoryRequest;
use App\Http\Requests\ProductCategory\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use App\Navigation\SuperAdminPath;
use App\Services\Core\ProductCategoryService;
use App\Services\File\FileUploadService;
use Inertia\Inertia;

class ProductCategoriesController extends BaseController
{
    public function __construct(
        private ProductCategoryService $categoryService,
        FileUploadService $fileUploadService
    ) {
        parent::__construct($fileUploadService);
    }

    public function index()
    {
        $query = $this->categoryService->getBaseQuery();
        $config = $this->categoryService->getDataTableConfig();

        $categories = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('product-categories/Index'), [
            'categories' => $categories,
            'filters' => $this->getFilters(['status', 'parent_id', 'created_from', 'created_to']),
            'columnLabels' => __('datatable.product_categories_columns'),
            'allCategories' => $this->categoryService->getAllCategories(),
        ]);
    }

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();

        return Inertia::render(SuperAdminPath::view('product-categories/actions/Create'), [
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductCategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());

        // Handle category image if provided
        if ($request->has('temp_files') && is_array($request->temp_files) && ! empty($request->temp_files)) {
            $this->fileUploadService->moveToMediaLibrary(
                $category,
                $request->temp_files,
                'category-image'
            );
        }

        return $this->successWithToast(__('toast.created_successfully'), __('toast.success'), 'super-admin.product-categories.index');
    }

    public function edit(ProductCategory $productCategory)
    {
        $categories = $this->categoryService->getAllCategories()
            ->reject(fn($cat) => $cat->id === $productCategory->id); // Exclude current category

        // Get existing files
        $existingFiles = $this->getExistingFilesForEdit($productCategory, 'category-image');

        return Inertia::render(SuperAdminPath::view('product-categories/actions/Edit'), [
            'category' => $productCategory->load('parent'),
            'categories' => $categories,
            'existingFiles' => $existingFiles,
        ]);
    }

    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $this->categoryService->update($productCategory, $request->validated());

        // Handle category image updates if provided
        if ($request->has('temp_files') && is_array($request->temp_files)) {
            $this->updateMediaFiles(
                $productCategory,
                $request->temp_files,
                'category-image'
            );
        }

        return $this->successWithToast(__('toast.updated_successfully'), __('toast.success'), 'super-admin.product-categories.index');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $this->categoryService->delete($productCategory);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.product-categories.index');
    }

    public function toggleStatus(ProductCategory $productCategory)
    {
        try {
            $this->categoryService->toggleStatus($productCategory);

            return $this->successWithToast(__('toast.status_updated_successfully'), __('toast.success'), 'super-admin.product-categories.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_status'), __('toast.error'), 'super-admin.product-categories.index');
        }
    }
}
