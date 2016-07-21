<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>不看实物也敢买</title>

    <!-- Fonts
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    -->
    <!-- Styles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">

<h1>upload image</h1>

<form action="/photo/fetch" method="POST">
    {{csrf_field()}}
    <div id="uploadImages">
        <img src="plus.png" id="chooseImage" width="200">
        <input type="hidden" id="media_id" name="media_id" value="">
    </div>
</form>

<button id="btnSubmit">确认</button>


<!-- JavaScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
     -->
<script src="{{ elixir('js/app.js') }}"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script>

    wx.config(<?php echo $wxconfig ?>);

    wx.ready(function() {
        var serverIds = [];

        function uploadImages(localImagesIds) {
            if (localImagesIds.length === 0) {
                alert('图片已经上传完毕，正在提交数据...');
                $('#media_id').attr('value',serverIds[0]);
                $('form').submit();
                return;
            }

            var localId = localImagesIds[0];
            //解决IOS无法上传的坑
            if (localId.indexOf("wxlocalresource") != -1) {
                localId = localId.replace("wxlocalresource", "wxLocalResource");
            }
            wx.uploadImage({
                localId: localId, // 需要上传的图片的本地ID，由chooseImage接口获得
                isShowProgressTips: 1, // 默认为1，显示进度提示
                success: function (res) {
                    serverIds.push(res.serverId); // 返回图片的服务器端ID
                    localImagesIds.shift();
                    uploadImages(localImagesIds);
                },
                fail: function (res) {
                    alert('上传失败，请重新上传！');
                }
            });
        }


        $('#chooseImage').click(function () {
            var $img = $(this);
            wx.chooseImage({
                count: 1, // 默认9
                sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    $img.attr('src', localIds[0]).addClass('uploaded');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        });


        //提交事件
        $('#btnSubmit').on('click', function () {

            var $chooseImages = $('#uploadImages img.uploaded');
            if ($chooseImages.length === 0) {
                alert('请上传照片！');
                return;
            }

            var localImagesIds = [];
            $chooseImages.each(function () {
                localImagesIds.push($(this).attr('src'));
            });

            alert(localImagesIds[0]);
            uploadImages(localImagesIds);
        });

    });



    wx.error(function(res){
        JSON.stringify(res)
    });
</script>
</body>
</html>
