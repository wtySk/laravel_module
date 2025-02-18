<?php

/**
 * Author: wtySk
 * Time: 04/12/2017  14:41
 */

namespace Modules\Core\Libs\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * 状态码 默认200
     * @var int
     */
    protected int $code = 200;
    /**
     * 返回数据 默认为空
     */
    protected  $data = [];

    /**
     * 权限
     * @var array
     */
    protected array $options = [];
    /**
     * 返回信息 默认成功
     * @var string
     */
    protected string $message = '请求成功';
    /**
     * 返回类型 默认为false
     * @var bool
     */
    protected bool $error = false;

    /**
     * 请求成功 返回给前台的统一json格式
     * @param string $message
     * @param  $data
     * @return JsonResponse
     */

    public function success(string $message = '请求成功',  $data = []): JsonResponse
    {
        if ($data) {
            $this->data = $data;
        }

        if ($message) {
            $this->message = $message;
        }

        $return = [
            'error' => $this->error,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ];
        return response()->json($return);
    }


    /**
     * 请求失败 返回给前台的统一json格式
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    public function failed(string $message = '请求失败', int $code = HTTP_BAD_REQUEST): JsonResponse
    {
        $this->error = true;
        if ($code) {
            $this->code = $code;
        }

        $this->message = match (env('APP_ENV')) {
            'production' => '服务器被蜗牛搬走了',
            default => $message,
        };
        return response()->json([
            'error' => $this->error,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data
        ]);
    }
}
