<?php

/**
 * Author: wtySk
 * Time: 13/11/2018  13:38
 */

namespace Modules\Admin\Basic\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Modules\Admin\Basic\Repositories\AdminRepository;
use Modules\Admin\Basic\Transform\AdminTransform;
use Modules\Core\Libs\Foundation\BaseService;
use Modules\Core\Libs\Traits\ApiResponse;

class AdminService extends BaseService
{
    use ApiResponse;

    protected AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * 查询
     *
     * @param array $where
     *
     * @return JsonResponse
     */
    public function select(array $where): JsonResponse
    {
        $list = $this->adminRepository->access($where);
        $list->setCollection($list->getCollection()->each(function ($item) {
            AdminTransform::trans($item);
        }));
        return $this->success(config('module.message.select.success'), $list);
    }

    /**
     * 单条查询
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function selectOne($id): JsonResponse
    {
        $record = $this->adminRepository->accessOne($id);
        $record = AdminTransform::transOne($record);
        return $this->success(config('module.message.select.success'), (array)$record);
    }

    /**
     * 添加
     *
     * @param array $inputs
     *
     * @return JsonResponse
     */
    public function store(array $inputs): JsonResponse
    {
        //用户设置密码 否则为123456
        $password = $inputs['password'] ?? '123456';
        $inputs['password'] = bcrypt($password);

        return DB::transaction(function () use ($inputs) {
            $this->adminRepository->store($inputs);
            return $this->success(config('module.message.store.success'));
        });
    }

    /**
     * 更新
     *
     * @param array $inputs
     * @param       $id
     *
     * @return JsonResponse
     */
    public function update(array $inputs, $id): JsonResponse
    {
        return DB::transaction(function () use ($inputs, $id) {
            $this->adminRepository->update($inputs, $id);
            return $this->success(config('module.message.update.success'));
        });
    }

    /**
     * 删除
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $res = $this->adminRepository->destroy($id);
        if (!$res) {
            return $this->failed(config('module.message.destroy.failed'));
        }
        return $this->success(config('module.message.destroy.success'));
    }

    /**
     * 批量删除
     *
     * @param $ids
     *
     * @return JsonResponse
     */
    public function batchDelete($ids): JsonResponse
    {
        $result = $this->adminRepository->batchDelete($ids);
        if (!$result) {
            return $this->failed(config('module.message.destroy.failed'));
        }
        return $this->success(config('module.message.destroy.success'));
    }
}
