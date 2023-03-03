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
            $this->runLog('error 1');
            echo 'error 1';
            exit;
        }

        // 公众号后台接口认证用
        if (isset($_GET['echostr'])) {
            echo $_GET['echostr'];
            exit;
        }


        if (empty($GLOBALS["HTTP_RAW_POST_DATA"])) {
            $this->runLog('error 2');
            echo 'error 2';
            exit;
        }

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $this->runLog($postStr);

        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $msgType = trim($postObj->MsgType);
        $openId = trim($postObj->FromUserName);

        switch ($msgType) {
            case "test":
                if ($postObj->Content == 'myid') {
                    $resultStr = $this->responseText($postObj, $openId);
                } else {
                    $resultStr = '';
                }

                break;
            case "event":
                $event = trim($postObj->Event);
                $resultStr = "event: " . $event;

                break;
            default:
                $resultStr = "Unknow msg type: " . $msgType;
                break;
        }

        echo !empty($resultStr) ? $resultStr : '';
    }

    private function runLog($msg)
    {
        error_log($msg . PHP_EOL, 3, '111');

        DB::table('logs')->insert([
            'data' => $msg,
//            'data' => json_encode([
//                'globals' => $GLOBALS,
//                'request' => $_REQUEST,
//                'get' => $_GET,
//                'post' => $_POST
//            ]),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
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
