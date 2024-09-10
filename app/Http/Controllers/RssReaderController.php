<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleXMLElement;

class RssReaderController extends Controller
{
    private $feeds = [
        '國際' => 'https://newtalk.tw/rss/category/1',
        '社會' => 'https://newtalk.tw/rss/category/14',
        '財經' => 'https://newtalk.tw/rss/category/3',
        '生活' => 'https://newtalk.tw/rss/category/5',
        '科技' => 'https://newtalk.tw/rss/category/8',
        '電競' => 'https://newtalk.tw/rss/category/10',
        '遊戲' => 'https://newtalk.tw/rss/category/17',
        '體育' => 'https://newtalk.tw/rss/category/102',
        '創夢' => 'https://newtalk.tw/rss/category/6',
    ];

    public function index()
    {
        return view('rss.index', ['feeds' => $this->feeds]);
    }

    public function show($feedName)
    {
        if (!isset($this->feeds[$feedName])) {
            abort(404);
        }

        $rssUrl = $this->feeds[$feedName];
        $rssContent = file_get_contents($rssUrl);
        $rss = new SimpleXMLElement($rssContent);

        $channel = [
            'title' => (string)$rss->channel->title,
            'description' => (string)$rss->channel->description,
            'link' => (string)$rss->channel->link,
            'lastBuildDate' => (string)$rss->channel->lastBuildDate,
        ];

        $items = [];
        foreach ($rss->channel->item as $item) {
            $imageUrl = '';
            if (isset($item->children('media', true)->content)) {
                $imageUrl = (string)$item->children('media', true)->content->attributes()->url;
                // 移除多余的 "http:" 前缀
                $imageUrl = preg_replace('/^http:https?:\/\//', 'http://', $imageUrl);
            }

            // 如果沒有圖片，使用預設圖片
            if (empty($imageUrl)) {
                $imageUrl = asset('images/no_image.jpg');
            }
            
            $items[] = [
                'title' => (string)$item->title,
                'description' => (string)$item->description,
                'link' => (string)$item->link,
                'pubDate' => (string)$item->pubDate,
                'imageUrl' => $imageUrl,
            ];
        }

        return view('rss.show', [
            'channel' => $channel,
            'items' => $items,
            'feedName' => $feedName
        ]);
    }
}
