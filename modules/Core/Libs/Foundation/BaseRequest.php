<?php
/**
 * Author: wtySk
 * Date: 2017/3/20 15:54
 */

namespace Modules\Core\Libs\Foundation;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Modules\Core\Libs\Traits\ApiResponse;
use stdClass;

/**
 * Core abstractBaseRequest
 *
 * @package Modules\Core\Libs\Foundation
 */
class BaseRequest extends FormRequest
{
    use ApiResponse;

    /**
     * 默认全部有权限通过
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * 验证字段规则
     *
     * @return mixed
     */
    public function rules():array
    {
        return [];
    }

    /**
     * 验证失败抛异常信息
     *
     * @param Validator $validator
     *
     * @throws ApiException
     */
    public function failedValidation(Validator $validator): void
    {
        foreach ($validator->errors()->toArray() as $error) {
            throw new ApiException($error['0'], HTTP_BAD_REQUEST);
        }

    }

    /**
     * 分页相关字段
     *
     * @return array
     */
    public function page(): array
    {
        return paginate(parent::all());
    }

    /**
     * 除分页字段
     * @return array
     */
    public function conditions():array
    {
        return parent::except(array_keys($this->page()));
    }

    /**
     * 分页和条件集合
     *
     * @return array
     */
    public function where(): array
    {
        return [
            'page'       => $this->page(),
            'conditions' => $this->conditions(),
        ];
    }

    /**
     * $results = $this->conditions()
     *
     * @param array|mixed $keys
     *
     * @return array
     */
    public function except($keys): array
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = $this->conditions();

        Arr::forget($results, $keys);

        return $results;
    }

    /**
     * $results = $this->conditions()
     *
     * @param array|mixed $keys
     *
     * @return array
     */
    public function only($keys): array
    {
        $results = [];

        $input = $this->conditions();

        $placeholder = new stdClass;

        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            $value = data_get($input, $key, $placeholder);

            if ($value !== $placeholder) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }
}
