<?php
/**
 * Author: wtySk
 * Date: 2017/10/17 9:52
 */

//通用全局方法
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


if (!function_exists('all_sql')) {
    /**
     * 打印全部的sql语句
     *
     * @return array
     */
    function all_sql(): array
    {
        $sql = DB::getQueryLog();
        $resSql = [];
        foreach ($sql as &$val) {
            foreach ($val['bindings'] as $val1) {
                $val['query'] = preg_replace('/\?/', "'{$val1}'", $val['query'], 1);
            }
            $resSql[] = $val;
        }

        return $resSql;
    }
}

if (!function_exists('last_sql')) {
    /**
     * 返回最后一条sql语句
     *
     * @return mixed
     */
    function last_sql()
    {
        $sql = DB::getQueryLog();
        $lastQuery = end($sql);
        foreach ($lastQuery['bindings'] as $val) {
            $lastQuery['query'] = preg_replace('/\?/', "'{$val}'", $lastQuery['query'], 1);
        }

        return $lastQuery;
    }
}


if (!function_exists('modules_view')) {
    /**
     *  返回视图方法
     *
     * @param null $view 字符串.号连接
     * @param array $data 数组参数
     * @param array $mergeData
     *
     * @return View
     */
    function modules_view($view = null, array $data = [], array $mergeData = []): View
    {
        $factory = app(ViewFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        //设置3个变量 模块名称 视图下文件夹名称 视图文件名称
        list($project, $moduleName, $viewName) = explode('.', $view);
        //如果是pjax请求 return _pjax.blade.php后缀
        //        if(is_pjax()){
        //            return view()->file(base_path('Modules/' . $project . '/' . $moduleName . '/Views/' . $viewName . '_pjax.blade.php'), $data, $mergeData);
        //        }
        return view()->file(base_path('modules/' . $project . '/' . $moduleName . '/Views/' . $viewName . '.blade.php'), $data, $mergeData);
    }
}

if (!function_exists('modules_namespace')) {
    function modules_namespace($file, $name = 'Controllers'): string
    {
        /**
         * 自动识别当前命名空间
         *
         * @param        $file
         * @param string $name 默认为Controllers
         *
         * @return string
         */
        $firstLevel = basename(dirname(dirname(dirname($file))));
        $secondLevel = basename(dirname((dirname($file))));

        return 'Modules\\' . $firstLevel . '\\' . $secondLevel . '\\' . $name;
    }
}

if (!function_exists('api_post')) {
    /**
     *  curl方法请求java接口
     *
     * @param array $data 数组格式数据
     * @param string $url 接口路由
     * @param string $domain 域名地址
     *
     * @return mixed
     */
    function api_post(array $data = [], string $url = '', string $domain = ''): mixed
    {
        //   //     $data =  clear_captcha($data);//去除captcha
        //        $json = json_encode($data,JSON_FORCE_OBJECT);//转换成json格式
        //        $sign_raw = env('PREFIX') . $json . env('SUFFIX');//拼接 sign
        //        $sign = md5($sign_raw);//md5  (sign)
        $url = $domain . $url;//拼接url
        //        //构造传递的数组
        //        $param = [
        //            'param' => $json,
        //            'user' => 'petal',
        //            'sign' => $sign
        //        ];
        $params = http_build_query($data);//数组转成字符串形式
        //     dd($params,$url);
        $res = post_data($params, $url);
        //   $res = post_data($url,$json);
        return json_decode($res);

    }
}

if (!function_exists('post_data')) {
    /**
     *  封装传递过来的参数
     *
     * @param $params
     *
     * @param $url
     * @param array $header
     * @return mixed
     */
    function post_data($params, $url, array $header = []): mixed
    {
        $ch = curl_init();
        $timeout = 60000;//设置60秒等待时间 毫秒为单位
        if (count($header)) {
            $headers = $header;
        } else {
            $headers = [];
            $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';//设置头文件content-type
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);//Post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //传递参数
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $handles = curl_exec($ch);
        curl_close($ch);

        return $handles;
    }
}

if (!function_exists('api_get')) {
    /**
     * @param array $data 数组格式数据
     * @param string $url 接口路由
     * @param string $domain 域名地址
     * @param array $headers
     *
     * @return mixed
     */
    function api_get(array $data = [], string $url = '', string $domain = '', array $headers = []): mixed
    {
        $url = $domain . $url;//拼接url
        $params = http_build_query($data);//数组转成字符串形式
        $res = get_data($params, $url, $headers);
        return json_decode($res);

    }
}

if (!function_exists('get_data')) {
    /**封装传递过来的参数
     *
     * @param       $params
     * @param       $url
     * @param array $headers
     *
     * @return mixed
     */
    function get_data($params, $url, $headers = [])
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url . '?' . $params);
        //注释头信息
        //        curl_setopt($curl, CURLOPT_HEADER, 1);
        if (count($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);

        //显示获得的数据
        return $data;
    }
}

if (!function_exists('api_json')) {
    /**
     *  curl方法请求
     *
     * @param array $data 数组格式数据
     * @param string $url 接口路由
     * @param string $method
     * @return mixed
     */
    function api_json($data = [], $url = '',$method = 'POST',$header = [])
    {
        $res = json_data($data, $url,$method,$header);
        return json_decode($res);
    }
}

if (!function_exists('json_data')) {
    /**
     *  封装传递过来的参数
     *
     * @param $params
     *
     * @param $url
     * @param $method
     * @param array $header
     * @return mixed
     */
    function json_data($params, $url,$method,$header = [])
    {
        $headers = array_merge($header,[
            'Content-Type: application/json',
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params,JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
}


if (!function_exists('paginate')) {
    /**
     * 返回分页条件
     *
     * @param $inputs
     *
     * @return array
     */
    function paginate($inputs): array
    {
        //todo
        $page = [];
        $page['page'] = $inputs['page'] ?? config('modulepage.page');
        $page['page_size'] = $inputs['page_size'] ?? config('modulepage.page_size');
        return $page;
    }
}


if (!function_exists('build_nested_array')) {

    /**
     * 递归方式构建树形
     *
     * @param array $nodes
     * @param int $parentId
     * @param string $parentString
     * @param string $childrenString
     *
     * @return array
     */
    function build_nested_array(array $nodes = [], int $parentId = 0, string $parentString = 'parent_id', string $childrenString = 'children'): array
    {
        $branch = [];
        foreach ($nodes as $k => $node) {
            if ($node[$parentString] == $parentId) {
                $children = build_nested_array($nodes, $node['id'], $parentString, $childrenString);
                if ($children) {
                    $node[$childrenString] = $children;
                }
                $branch[] = $node;
            }
        }

        return $branch;
    }
}




/*
|--------------------------------------------------------------------------
| 区分 helpers
|--------------------------------------------------------------------------
|
|
*/

// 隐藏手机号
if (!function_exists('hide_mobile')) {
    function hide_mobile($mobile): array|string
    {
        $string = '';

        if (filled($mobile)) {
            if (strlen($mobile) === 11) {
                $string = substr_replace($mobile, '****', 3, 4);
            } else {
                $string = substr($mobile, 0, 3) . '****' . substr($mobile, -1, 4);
            }
        }

        return $string;
    }
}

// 处理搜索时的时间范围

// 是否是在 CLI 环境下
if (!function_exists('is_cli')) {
    function is_cli(): bool
    {
        return PHP_SAPI === 'cli';
    }
}


