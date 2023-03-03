<?php
// +----------------------------------------------------------------------
// | 文件: index.php
// +----------------------------------------------------------------------
// | 功能: 提供count api接口
// +----------------------------------------------------------------------
// | 时间: 2021-12-12 10:20
// +----------------------------------------------------------------------
// | 作者: rangangwei<gangweiran@tencent.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers;

use Error;
use Exception;
use App\Counters;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    public function notice()
    {
        // 公众号后台接口认证用
        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            exit;
        }
    }
}
