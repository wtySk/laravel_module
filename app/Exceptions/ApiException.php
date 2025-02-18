<?php
/**
 * Author: wtySk
 * Time: 2025/2/18  11:07
 */

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    function __construct($msg = '没有找到查询结果', $code = HTTP_BAD_REQUEST)
    {
        $errors = '';
        //如果参数为数组转成字符串
        if (is_array($msg)) {
            foreach ($msg as $key => $value) {
                $errors .= $key.'->'.$value.'  ';
            }
            $msg = $errors;
        }

        parent::__construct($msg, $code);
    }
}
