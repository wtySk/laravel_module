<?php

/**
 * Author: wtySk
 * Time: 13/11/2018  13:36
 */

namespace Modules\Admin\Basic\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Admin\Basic\Requests\AdminRequest;
use Modules\Admin\Basic\Services\AdminService;
use Modules\Core\Libs\Foundation\BaseController;
use Modules\Core\Libs\Foundation\BaseRequest;

class AdminController extends BaseController
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * 查询
     * @param BaseRequest $request
     * @return JsonResponse
     */
    public function index(BaseRequest $request): JsonResponse
    {
        $where = $request->where();
        return $this->adminService->select($where);
    }

    /**
     * 查询单条
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->adminService->selectOne($id);
    }

    /**
     * 添加
     * @param AdminRequest $request
     * @return JsonResponse
     */
    public function store(AdminRequest $request): JsonResponse
    {
        $data = $request->conditions();
        return $this->adminService->store($data);
    }

    /**
     * 更新用户信息
     * @param AdminRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(AdminRequest $request, $id): JsonResponse
    {
        $data = $request->only([
            'name'
        ]);
        return $this->adminService->update($data, $id);
    }

    /**
     * 删除用户信息
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->adminService->destroy($id);
    }

    /**
     * 批量删除用户
     * @param BaseRequest $request
     * @return JsonResponse
     */
    public function batchDelete(BaseRequest $request): JsonResponse
    {
        $ids = $request->input('ids')??[];
        return $this->adminService->batchDelete($ids);
    }
}
