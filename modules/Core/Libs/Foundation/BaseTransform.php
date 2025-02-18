<?php

/**
 * Author: wtySk
 * Time: 22/12/2017  14:25
 */

namespace Modules\Core\Libs\Foundation;

class BaseTransform
{
    protected static $model;

    /**
     * 修改创建时间 更新时间字段
     */
    public static function transform()
    {

    }

    /**
     * 蛇形->驼峰方法
     * @param $original
     * @param string $current
     * @param string $type
     */
    public static function change($original, string $current = '', string $type = ''): void
    {
        if ($current != '') {
            if ($type == 'string') {
                self::$model[$current] = (string)self::$model[$original] ?? '';
            } elseif ($type == 'int') {
                self::$model[$current] = (integer)self::$model[$original] ?? 0;
            } elseif ($type == 'float') {
                self::$model[$current] = (float)self::$model[$original] ?? 0.00;
            } else {
                self::$model[$current] = self::$model[$original] ?? '';
            }
        }
        unset(self::$model[$original]);
    }

    /**
     * 关联对象 转成特定字段方法
     * @param $original
     * @param $variable
     * @param $current
     */
    public static function changeVariable($original, $variable, $current): void
    {
        self::$model[$current] = $variable ?? '';
        unset(self::$model[$original]);
    }

}
