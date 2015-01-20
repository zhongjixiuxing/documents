<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>jquery+html5实现图片选取裁剪并上传功能 - psd素材网</title>
        <!-- add styles -->
        <link href="../../css/img/css/main.css" rel="stylesheet" type="text/css" />
        <link href="../../css/img/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />

        <!-- add scripts -->
        <script src="../../js/img/js/jquery.min.js"></script>
        <script src="../../js/img/js/jquery.Jcrop.min.js"></script>
        <script src="../../js/img/js/script.js"></script>
    </head>
    <body>
        <div class="demo" style=" margin-top:60px;">
            <div class="bheader"><h2>——图像上传表单——</h2></div>
            <div class="bbody">

                <!-- upload form -->
                <form id="upload_form" enctype="multipart/form-data" method="post" action="upLoadImage" onSubmit="return checkForm()">
                    <!-- hidden crop params -->
                    <input type="hidden" id="x1" name="x1" />
                    <input type="hidden" id="y1" name="y1" />
                    <input type="hidden" id="x2" name="x2" />
                    <input type="hidden" id="y2" name="y2" />

                    <h2>第一步:请选择图像文件</h2>
                    <div><input type="file" name="image_file" id="image_file" onChange="fileSelectHandler()" /></div>

                    <div class="error"></div>

                    <div class="step2">
                        <h2>请选择需要截图的部位,然后按上传</h2>
                        <img id="preview" />

                        <div class="info">
                            <label>文件大小</label> <input type="text" id="filesize" name="filesize" />
                            <label>类型</label> <input type="text" id="filetype" name="filetype" />
                            <label>图像尺寸</label> <input type="text" id="filedim" name="filedim" />
                            <label>宽度</label> <input type="text" id="w" name="w" />
                            <label>高度</label> <input type="text" id="h" name="h" />
                        </div>
                        <input type="submit" value="上传" />
                    </div>
                </form>
            </div>
        </div>
<div style="text-align:center;clear:both"><br>
<p>适用浏览器：FireFox、Chrome、Opera. 不支持IE8、360、Safari、傲游、搜狗、世界之窗。</p><br>

</div>
</body>
</html>
