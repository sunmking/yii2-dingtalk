<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv
 * Date: 2018/9/7
 * Time: 13:39
 * @author saviorlv <1042080686@qq.com>
 */

namespace Saviorlv\DingTalk;

use Yii;
use GuzzleHttp\Client;
use yii\base\Component;
use yii\base\InvalidConfigException;
use GuzzleHttp\Exception\RequestException;

class Robot extends Component
{
    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var string
     */
    public $apiUrl = 'https://oapi.dingtalk.com/robot/send';

    /**
     * @var array
     */
    public $guzzleOptions = [];

    /**
     * @var array
     */
    public $msgTypeList = ['text','link','markdown','actionCard','feedCard'];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->accessToken === null) {
            throw new InvalidConfigException('The "accessToken" property must be set.');
        }
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * 发送文本消息
     * @param string $content
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return mixed
     */
    public function sendTextMsg($content, array $atMobiles = [], $isAtAll = false)
    {
        $query = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
            ],
            'at' => [
                'isAtAll' => $isAtAll
            ],
        ];
        if (is_array($atMobiles) && count($atMobiles)>0) {
            $query['at']['atMobiles'] = $atMobiles;
        }
        return $this->sendMsg($query);
    }

    /**
     * 发送链接
     * @param string $title
     * @param string $text
     * @param string $picUrl
     * @param string $messageUrl
     * @return mixed
     */
    public function sendLinkMsg($title, $text, $picUrl = '', $messageUrl)
    {
        $query = [
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'text' => $text,
                'picUrl' => $picUrl,
                'messageUrl' => $messageUrl
            ],
        ];
        return $this->sendMsg($query);
    }

    /**
     * 发送MarkDown 消息
     * @param string $title
     * @param string $content
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return mixed
     */
    public function sendMarkdownMsg($title, $content, array $atMobiles = [], $isAtAll = false)
    {
        $query = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $content,
            ],
            'at' => [
                'isAtAll' => $isAtAll
            ],
        ];
        if (is_array($atMobiles) && count($atMobiles)>0) {
            $query['at']['atMobiles'] = $atMobiles;
        }
        return $this->sendMsg($query);
    }

    /**
     * 整体跳转ActionCard类型
     * @param $title
     * @param $content
     * @param $singleURL
     * @param int $hideAvatar
     * @param int $btnOrientation
     * @param string $singleTitle
     * @return mixed
     */
    public function sendActionCardMsg($title, $content, $singleURL, $hideAvatar = 0, $btnOrientation = 0, $singleTitle = '阅读原文')
    {
        $query = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $content,
                'hideAvatar' => $hideAvatar,
                'btnOrientation' => $btnOrientation,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL
            ],
        ];
        return $this->sendMsg($query);
    }

    /**
     * 独立跳转ActionCard类型
     * @param $title
     * @param $content
     * @param int $hideAvatar
     * @param int $btnOrientation
     * @param array $btns
     * @return mixed
     */
    public function sendSingleActionCardMsg($title, $content, $hideAvatar = 0, $btnOrientation = 0, array $btns=[])
    {
        $query = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $content,
                'hideAvatar' => $hideAvatar,
                'btnOrientation' => $btnOrientation,
                'btns' => $btns
            ],
        ];
        return $this->sendMsg($query);
    }

    /**
     * @param string $type
     * @param array $msgData
     * @return mixed
     */
    public function sendMsg(array $msgData=[])
    {
        $query = \json_encode($msgData);
        try {
            $response = $this->getHttpClient()->get($this->apiUrl."?access_token=".$this->accessToken, [
                'query' => $msgData,
                'headers' => [
                    'Accept'     => 'application/json'
                ]
            ])->getBody()->getContents();

            return $response;
        } catch (\Exception $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
    }
}