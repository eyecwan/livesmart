<?php

namespace App\Repositories;

use App\Photo;
use Log;


class PhotoFetchRepository{


    protected $wechat;

    public function __construct()
    {
        $this->wechat = \App::make('EasyWeChat\Foundation\Application');
    }

    public function fetchFromMediaId($media_id){


        $access_token = $this->wechat->access_token->getToken();

        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=". $access_token. "&media_id=". $media_id;
        $media = $this->fetchWechatMedia($url);
        $media_file_extension = $this->mediaTypeToFileExtension($media['header']['content_type']);
        $media_filename = 'image/wx/'. time().".".$media_file_extension;
        $this->saveWechatMedia($media_filename,$media['body'] );

        $photo = Photo::create([
            'path'=>$media_filename,
            'media_id'=> $media_id,
        ]);
        Log::info($photo);
        return $photo;
    }

    public function fetchWechatMedia($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $body = curl_exec($curl);
        $header = curl_getinfo($curl);
        curl_close($curl);
        return compact('body','header');
    }

    public function saveWechatMedia($name,$content) {
        $local_file = fopen($name,'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file,$content)){
                fclose($local_file);
            }
        }
    }

    public function mediaTypeToFileExtension($type){
        switch ($type){
            case 'image/jpeg':
                $extension = "jpg";
                break;
            case 'image/png':
                $extension = "png";
                break;
            //其他文件格式自行添加
            case 'image/gif':
                $extension = "gif";
                break;
            default:
                $extension = "notype";
                break;

        }
        return $extension;
    }
}