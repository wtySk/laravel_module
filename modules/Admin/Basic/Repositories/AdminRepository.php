<?php

/**
 * Author: wtySk
 * Time: 13/11/2018  13:37
 */

namespace Modules\Admin\Basic\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Common\Models\Admin;
use Modules\Admin\Common\Repositories\AdminRepository as BaseRepository;

class AdminRepository extends BaseRepository
{

    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }
    /**
     * 用户列表
     * @param array $where
     * @return mixed
     */
    public function access(array $where = []): mixed
    {
        $conditions = $where['conditions'];
        $page = $where['page'];
        $builder = $this->addExistCondition()->addNameCondition();
        return $builder->model->paginate($page['page_size']);

    }

    /**
     * 查询单条
     * @param $id
     * @return mixed
     */
    public function accessOne(int $id)
    {
        return $this->model->exist()->where('id', $id)->first();
    }

    /**
     * 添加
     * @param array $inputs
     * @return mixed
     */
    public function store(array $inputs)
    {
        return $this->model->create($inputs);
    }

    /**
     * 更新
     * @param $inputs
     * @param $id
     * @return mixed
     */
    public function update($inputs, $id)
    {
        return $this->model->find($id)->update($inputs);
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return optional($this->model->find($id))->delete();
    }

    /**
     * 批量删除
     * @param $ids
     * @return bool
     */
    public function batchDelete($ids)
    {
         return DB::transaction(function() use ($ids){
             $this->model->whereIn('id', $ids)->delete();
         });
    }

    /**
     * 存在的用户
     * @return BaseRepository
     */
    public function addExistCondition()
    {
        $this->model = $this->model->where('deleted_at', null);
        return $this;
    }

    /**
     * 通过名字查询
     * @return $this
     */
    public function addNameCondition(): static
    {
        $name = $this->conditions['name'] ?? '';
        if ($name) {
            $this->model = $this->model->where('name', 'like', '%' . $name . '%');
        }
        return $this;
    }
}
