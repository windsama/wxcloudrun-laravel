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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    private $appId = 'wxd78d18f6ccd16256';
    private $secret = '53cb82b9fd8f22dae374d3d6abcf8f53';
    private $token = '329f7f249b8b60697dfb481a05da6495';

    public function notice()
    {
        if (!$this->checkSignature()) {
            echo 'error';
            exit;
        }

        // 公众号后台接口认证用
        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            exit;
        }

        DB::table('logs')->insert([
            'data' => json_encode([
                'globals' => $GLOBALS,
                'request' => $_REQUEST,
                'get' => $_GET,
                'post' => $_POST
            ]),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        echo 'success';
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $tmpArr = [$this->token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function responseText($object, $content, $flag = 0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";

        return sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
    }
}
