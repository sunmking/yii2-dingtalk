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
use yii\base\InvalidParamException;
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
     * @param array $msgData
     * @return mixed
     */
    public function sendTextMsg(array $msgData=[]){
        if (!\is_array($msgData)) {
            throw new InvalidParamException('msgData value type must be array');
        }
        if(count($msgData)==0){
            throw new InvalidParamException('msgData value must');
        }

        return $this->sendMsg('text',$msgData);
    }

    /**
     * @param array $msgData
     * @return mixed
     */
    public function sendLinkMsg(array $msgData=[]){
        if (!\is_array($msgData)) {
            throw new InvalidParamException('msgData value type must be array');
        }
        if(count($msgData)==0){
            throw new InvalidParamException('msgData value must');
        }

        return $this->sendMsg('link',$msgData);
    }

    /**
     * @param array $msgData
     * @return mixed
     */
    public function sendMarkdownMsg(array $msgData=[]){
        if (!\is_array($msgData)) {
            throw new InvalidParamException('msgData value type must be array');
        }
        if(count($msgData)==0){
            throw new InvalidParamException('msgData value must');
        }

        return $this->sendMsg('markdown',$msgData);
    }

    /**
     * @param array $msgData
     * @return mixed
     */
    public function sendActionCardMsg(array $msgData=[]){
        if (!\is_array($msgData)) {
            throw new InvalidParamException('msgData value type must be array');
        }
        if(count($msgData)==0){
            throw new InvalidParamException('msgData value must');
        }

        return $this->sendMsg('actionCard',$msgData);
    }

    /**
     * @param array $msgData
     * @return mixed
     */
    public function sendFeedCardMsg(array $msgData=[]){
        if (!\is_array($msgData)) {
            throw new InvalidParamException('msgData value type must be array');
        }
        if(count($msgData)==0){
            throw new InvalidParamException('msgData value must');
        }

        return $this->sendMsg('feedCard',$msgData);
    }
    /**
     * @param string $type
     * @param array $msgData
     * @return mixed
     */
    public function sendMsg($type = 'text', array $msgData=[])
    {
        if (!\in_array(\strtolower($type), $this->msgTypeList)) {
            throw new InvalidParamException('Invalid response type: '.$type);
        }

        if (!\is_array($msgData)) {
            throw new InvalidParamException('msgData value type must be array');
        }

        $query = \json_encode($msgData);

        try {
            $response = $this->getHttpClient()->get($this->apiUrl."?access_token=".$this->accessToken, [
                'query' => $query,
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