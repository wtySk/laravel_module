<?php

/**
 * Author: wtySk
 * Time: 13/11/2018  13:38
 */

namespace Modules\Admin\Basic\Transform;

use Modules\Core\Libs\Foundation\BaseTransform;

class AdminTransform extends BaseTransform
{
    public static function transOne($record)
    {
        if (!$record) {
            return '';
        }
        self::$model = $record;
        //加载创建人
//        self::$model->creator = $value->creator ?? '--';
//        self::$model->role = self::$model->role ?? '--';
        return self::$model;
    }

    public static function trans($record)
    {
        if (!$record){
            return [];
        }
        self::$model = $record;
//        self::$model->creator = $record->creator ?? '--';
//        self::$model->role = self::$model->role ?? '--';
        return self::$model;
    }
}
