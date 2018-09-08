# yii2-weather 基于高德开放平台的天气信息组件。

## 说明

>群机器人是钉钉群的高级扩展功能。群机器人可以将第三方服务的信息聚合到群聊中，实现自动化的信息同步。目前，大部分机器人在添加后，还需要进行Webhook配置，才可正常使用(配置说明详见操作流程中的帮助链接)。

>例如：通过聚合GitHub，GitLab等源码管理服务，实现源码更新同步。通过聚合Trello，JIRA等项目协调服务，实现项目信息同步。

>另外，群机器人支持Webhook协议的自定义接入，支持更多可能性，例如：你可将运维报警通过自定义机器人聚合到钉钉群实现提醒功能。


## 安装

```sh
$ composer require saviorlv/yii2-dingtalk -vvv
```

## 配置

在使用本扩展之前，你需要去 [群机器人](https://open-doc.dingtalk.com/microapp/serverapi2/nr29om) 获取相关信息。


## 使用

> 在config/main.php配置文件中定义component配置信息

```php
'components' => [
  .....
  'robot' => [
      'class' => 'Saviorlv\Dingtalk\Robot',
      'accessToken' => 'xxxxxxxxx'
    ],
  ....
]

```

###  发送 `Text` 信息

方法：

```php
public function sendTextMsg($content, array $atMobiles = [], $isAtAll = false){}
```

参数：

<table>
<thead>
<tr>
<th style="text-align:left;">参数</th>
<th style="text-align:left;">参数类型</th>
<th style="text-align:left;">必须</th>
<th style="text-align:left;">说明</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align:left;">content</td>
<td style="text-align:left;">String</td>
<td style="text-align:left;">是</td>
<td style="text-align:left;">消息内容</td>
</tr>
<tr>
<td style="text-align:left;">atMobiles</td>
<td style="text-align:left;">Array</td>
<td style="text-align:left;">否</td>
<td style="text-align:left;">被@人的手机号</td>
</tr>
<tr>
<td style="text-align:left;">isAtAll</td>
<td style="text-align:left;">bool</td>
<td style="text-align:left;">否</td>
<td style="text-align:left;">@所有人时：true，否则为：false</td>
</tr>
</tbody>
</table>

实例：

```php
$response = Yii::$app->robot->sendTextMsg(
    "必要忘记上下班打卡",
    [
        136*****134,
        136*****132
    ],
    false
);
```

###  发送 `Link` 链接

方法：

```php
public function sendLinkMsg($title, $text, $picUrl = '', $messageUrl){}
```

参数：

<table>
<thead>
<tr>
<th style="text-align:left;">参数</th>
<th style="text-align:left;">参数类型</th>
<th style="text-align:left;">必须</th>
<th style="text-align:left;">说明</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align:left;">title</td>
<td style="text-align:left;">String</td>
<td style="text-align:left;">是</td>
<td style="text-align:left;">消息标题</td>
</tr>
<tr>
<td style="text-align:left;">text</td>
<td style="text-align:left;">String</td>
<td style="text-align:left;">是</td>
<td style="text-align:left;">消息内容。如果太长只会部分展示</td>
</tr>
<tr>
<td style="text-align:left;">messageUrl</td>
<td style="text-align:left;">String</td>
<td style="text-align:left;">是</td>
<td style="text-align:left;">点击消息跳转的URL</td>
</tr>
<tr>
<td style="text-align:left;">picUrl</td>
<td style="text-align:left;">String</td>
<td style="text-align:left;">否</td>
<td style="text-align:left;">图片URL</td>
</tr>
</tbody>
</table>

实例：

```php
$response = Yii::$app->robot->sendLinkMsg(
    "上下班打卡",
    "有些同志上下班就是不打卡，QAQ",
    "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1536321778370&di=46a7abc85f6fe1de8df8fbdc5b95d68d&imgtype=0&src=http%3A%2F%2Fimg4.duitang.com%2Fuploads%2Fitem%2F201407%2F21%2F20140721224026_KU3GA.thumb.700_0.jpeg",
    "https://github.com/saviorlv?tab=repositories"
);
```

###  发送 `MarkDown` 消息

方法：

```php
public function sendMarkdownMsg($title, $content, array $atMobiles = [], $isAtAll = false){}
```

参数：

<table>
<thead>
<tr>
<th style="text-align:left;">参数</th>
<th style="text-align:left;">必选</th>
<th style="text-align:left;">类型</th>
<th style="text-align:left;">说明</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align:left;">title</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">首屏会话透出的展示内容</td>
</tr>
<tr>
<td style="text-align:left;">content</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">markdown格式的消息</td>
</tr>
<tr>
<td style="text-align:left;">atMobiles</td>
<td style="text-align:left;">Array</td>
<td style="text-align:left;">否</td>
<td style="text-align:left;">被@人的手机号(在text内容里要有@手机号)</td>
</tr>
<tr>
<td style="text-align:left;">isAtAll</td>
<td style="text-align:left;">bool</td>
<td style="text-align:left;">否</td>
<td style="text-align:left;">@所有人时：true，否则为：false</td>
</tr>
</tbody>
</table>

实例：

```php
$response = Yii::$app->robot->sendMarkdownMsg(
        "上下班打卡",
        " ###有些同志上下班就是不打卡，`QAQ`",
        [
            136*****134,
            136*****132
        ],
        false
    );
```

###  整体跳转 `ActionCard`类型

方法：

```php
public function sendActionCardMsg($title, $content, $singleURL, $hideAvatar = 0, $btnOrientation = 0, $singleTitle = '阅读原文'){}
```

参数：

<table>
<thead>
<tr>
<th style="text-align:left;">参数</th>
<th style="text-align:left;">必选</th>
<th style="text-align:left;">类型</th>
<th style="text-align:left;">说明</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align:left;">title</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">首屏会话透出的展示内容</td>
</tr>
<tr>
<td style="text-align:left;">content</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">markdown格式的消息</td>
</tr>
<tr>
<td style="text-align:left;">singleTitle</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">单个按钮的方案。(设置此项和singleURL后btns无效)</td>
</tr>
<tr>
<td style="text-align:left;">singleURL</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">点击singleTitle按钮触发的URL</td>
</tr>
<tr>
<td style="text-align:left;">btnOrientation</td>
<td style="text-align:left;">false</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">0-按钮竖直排列，1-按钮横向排列</td>
</tr>
<tr>
<td style="text-align:left;">hideAvatar</td>
<td style="text-align:left;">false</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">0-正常发消息者头像，1-隐藏发消息者头像</td>
</tr>
</tbody>
</table>

实例：

```php
$response = Yii::$app->robot->sendActionCardMsg(
        "上下班打卡",
        " 有些同志上下班就是不打卡，QAQ",
        "https://github.com/saviorlv?tab=repositories",
        0,
        0,
        "你看不看"
    );
```

###  独立跳转 `ActionCard` 类型

方法：

```php
public function sendSingleActionCardMsg($title, $content, $hideAvatar = 0, $btnOrientation = 0, array $btns=[]){}
```

参数：

<table>
<thead>
<tr>
<th style="text-align:left;">参数</th>
<th style="text-align:left;">必选</th>
<th style="text-align:left;">类型</th>
<th style="text-align:left;">说明</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align:left;">title</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">首屏会话透出的展示内容</td>
</tr>
<tr>
<td style="text-align:left;">content</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">markdown格式的消息</td>
</tr>
<tr>
<td style="text-align:left;">btns</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">array</td>
<td style="text-align:left;">按钮的信息：title-按钮方案，actionURL-点击按钮触发的URL</td>
</tr>
<tr>
<td style="text-align:left;">btnOrientation</td>
<td style="text-align:left;">false</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">0-按钮竖直排列，1-按钮横向排列</td>
</tr>
<tr>
<td style="text-align:left;">hideAvatar</td>
<td style="text-align:left;">false</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">0-正常发消息者头像，1-隐藏发消息者头像</td>
</tr>
</tbody>
</table>

实例：

```php
$response = Yii::$app->robot->sendSingleActionCardMsg(
            "上下班打卡",
            " 有些同志上下班就是不打卡，QAQ",
            0,
            1,
            [
                [
                    "title"=> "内容不错", 
                    "actionURL"=> "https://www.dingtalk.com/"
                ], 
                [
                    "title"=> "不感兴趣", 
                    "actionURL"=> "https://www.dingtalk.com/"
                ]
            ]
        );
```

###  `FeedCard` 类型

方法：

```php
public function sendFeedCardMsg(array $links=[]){}
```

参数：

<table>
<thead>
<tr>
<th style="text-align:left;">参数</th>
<th style="text-align:left;">必选</th>
<th style="text-align:left;">类型</th>
<th style="text-align:left;">说明</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align:left;">title</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">单条信息文本</td>
</tr>
<tr>
<td style="text-align:left;">messageURL</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">点击单条信息到跳转链接</td>
</tr>
<tr>
<td style="text-align:left;">picURL</td>
<td style="text-align:left;">true</td>
<td style="text-align:left;">string</td>
<td style="text-align:left;">单条信息后面图片的URL</td>
</tr>
</tbody>
</table>

实例：

```php
  $response = Yii::$app->robot->sendFeedCardMsg([
                [
                    "title"=> "时代的火车向前开",
                    "messageURL"=> "https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI",
                    "picURL"=> "http://b.hiphotos.baidu.com/image/pic/item/f603918fa0ec08fa98d87c8054ee3d6d55fbda39.jpg"
                ],[
                    "title"=> "时代的火车向前开",
                    "messageURL"=> "https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI",
                    "picURL"=> "http://b.hiphotos.baidu.com/image/pic/item/f603918fa0ec08fa98d87c8054ee3d6d55fbda39.jpg"
                ],
        ]);
```


## 参考
- [钉钉自定义机器人](https://open-doc.dingtalk.com/microapp/serverapi2/qf2nxq)

