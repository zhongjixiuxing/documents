<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="http://apps.bdimg.com/libs/jquerymobile/1.4.2/jquery.mobile.min.css">
<script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script> -->
<script src="http://apps.bdimg.com/libs/jquerymobile/1.4.2/jquery.mobile.min.js"></script>

<script>
  var flag = true;
  var flag2 = false;
  var appId_temp = 0; //标志当前用户操作的App, 如果为0 说明没有app选中操作

  $(function(){

    //注册整个浏览器窗口的点击事件
    $(document).click(function(e){
      // e = window.event || e; //兼容IE7
      obj = event.target || event.srcElement;
      if ($(obj).is("#menu *")){
      } else {
        if(flag2 == true){
          $("#menu").hide();
          flag = true;
          event.stopPropagation();
          flag2 = false;
        }
      }
    });

    $(".btmiddle").click(function() {
        if ($(".btmiddle").hasClass("bt")){
            $(".btmiddle").removeClass("bt");
            $(".btmiddle").addClass("clicked");
            $("#menu").show();
        } else {
            $(".btmiddle").removeClass("clicked");
            $(".btmiddle").addClass("bt");
            $("#menu").hide();
        }
    });

    $("#a_account").on("click",function(){
      location.href = "/Faeva2/account/account/index";
    });
    $("#a_createApp").on("click",function(){
      location.href = "/Faeva2/app/app/createApp";
    });
    $("#img_delete").on("click",function(){

    });
    $("#a_Members").on("click",function(){
      alert("a_Members");
    });
    $("#a_profile").on("click",function(){
      alert("a_profile");
    });
    $("#a_subscription").on("click", function(){
      alert("a_subscription");
    });
    $("#a_logout").on("click", function(){
      alert("a_logout");
    });

    $(".img_del").on("click", function(){
      alert("iimg");
      appId = $(this).attr("id");
      alert("appId : "+appId);
      location.href = "/Faeva2/app/app/delete/"+appId;
    });
    $(".img_setup").on("click", function(){
      flag2 = true;
      appId = $(this).attr("id");
      appId_temp = appId;
      var X= this.getBoundingClientRect().left+document.documentElement.scrollLeft;
      var Y =this.getBoundingClientRect().top+document.documentElement.scrollTop;

      var divcss = {
        margin: 50+"px 0 0 "+(X-15)+"px",
        display: "none",
        position:'absolute'
      };

      if (flag == true) {
          flag = false;
          $("#menu").css(divcss);
          $("#menu").show();
      }else{
          flag = true;
          $("#menu").css(divcss);
          $("#menu").hide();
      }

      event.stopPropagation();
      // alert("x : "+X+"  Y : "+Y);
    });
  });
</script>

<script>
  function onCardClick(){
    alert("onCardClick");
  }

  function app_edit(){
    alert("edit app_temp : "+appId_temp);
  }

  function app_delete(){
    alert("delete appId_temp : "+appId_temp);
  }

</script>

<style type="text/css">
  .div_app{
    border:1px solid #5f0;
    width:160px;
    height:120px;
  }
  .panel{
    border:1px solid #5f0;
    width:20%;
    float:left;
    margin-left:1%;
  }

  .content{
    display：block;
    padding-top:2%;
    padding-left:2%;
  }
  .app_name{
    float:left;
  }

.icon
{
    background: url(/Faeva2/img/an2.jpg) no-repeat;
    width: 300px;
    line-height: 200px;
    display: inline-block;
}

.icon-set
{
 background-position: -380px -200px;
}

.icon-add{
   background-position: -55px -40px;
}

.icon-delete{
   background-position: -15px -340px;
}

.icon-edit{
   background-position: -330px -670px;
}

.app_desc{
  margin-left:1%;
  border:1px solid #5f0;
}


.img{
  width:30px;
  height:30px;
  margin-right:2px;width
}
</style>

<style>
    #box {
        margin-top: 20px;
    }
    .bt, .clicked {
        height: 20px;
        color: #666;
        font-size: 13px;
        padding: 4px 10px;
        text-decoration: none;
        background: #f9f9f9;
    }
    #box .bt {
        background: -moz-linear-gradient(top,  #fff,  #f3f3f3);
        background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#f3f3f3));

        /* 用于 Internet Explorer 5.5 - 7 */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff, endColorstr=#f3f3f3);
        /* 用于 Internet Explorer 8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff, endColorstr=#f3f3f3)";
    }
    #box .bt:hover {
        background: #f3f3f3;
        background: -moz-linear-gradient(top,  #fff,  #e9e9e9);
        background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#e9e9e9));

        /* 用于 Internet Explorer 5.5 - 7 */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff, endColorstr=#e9e9e9);
        /* 用于 Internet Explorer 8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffff, endColorstr=#e9e9e9)";
    }
    #box .bt:active, .clicked {
        background: #e9e9e9;
        background: -moz-linear-gradient(top,  #e9e9e9,  #fff);
        background: -webkit-gradient(linear, left top, left bottom, from(#e9e9e9), to(#fff));

        /* 用于 Internet Explorer 5.5 - 7 */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#e9e9e9, endColorstr=#ffffff);
        /* 用于 Internet Explorer 8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#e9e9e9, endColorstr=#ffffff)";
    }
    .btleft {
        border: 1px solid #e3e3e3;
        -webkit-border-radius: .5em 0 0 .5em;
        -moz-border-radius: .5em 0 0 .5em;
        border-radius: .5em 0 0 .5em;
    }
    .btleft span {
        font-size: 15px;
    }
    .btmiddle {
        border: 1px solid #e3e3e3;
        border-width: 1px 0;
        margin: 0 -4px;
    }
    .btright {
        border: 1px solid #e3e3e3;
        -webkit-border-radius: 0 .5em .5em 0;
        -moz-border-radius: 0 .5em .5em 0;
        border-radius: 0 .5em .5em 0;
    }
    .btmiddle span, .btright span {
        font-size: 9px;
        position: relative;
        top: -2px;
    }
    #menu {
        margin: 10px 0 0 10px;
        display: none;
    }
    #triangle {
        border: 1px solid #d9d9d9;
        border-width: 2px 0 0 2px;
        width:10px;
        height:10px;
        /* 用于 firefox, safari, chrome, 等等. */
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -o-transform:rotate(45deg);
        z-index: 1;
        position: relative;
        bottom: -4px;
        margin-left: 25px;
        background: #fff;
    }
    #tooltip_menu {
        background: #fff;
        -webkit-border-radius: .5em;
        -moz-border-radius: .5em;
        border-radius: .5em;
        width: 220px;
        -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,.5);
        -moz-box-shadow: 0px 0px 3px rgba(0,0,0,.5);
        box-shadow: 0px 0px 3px rgba(0,0,0,.5);
        padding: 2px;
    }
    #tooltip_menu a {
        z-index: 2;
        padding: 0 0 7px 2px;
        display: block;
        text-decoration: none;
        color: #0066cc;
        font-size: 13px;
    }
    #tooltip_menu a:hover {
        background: #0066cc;
        color: #fff;
    }
    #tooltip_menu a img {
        position: relative;
        top: 5px;
        border: 0;
    }
    .menu_top {
        -webkit-border-radius: .5em .5em 0 0;
        -moz-border-radius: .5em .5em 0 0;
        border-radius: .5em .5em 0 0;
    }
    .menu_bottom {
        -webkit-border-radius: 0 0 .5em .5em;
        -moz-border-radius: 0 0 .5em .5em;
        border-radius: 0 0 .5em .5em;
    }
</style>

</head>
<body>

<div data-role="page">
<div></div>
<div data-role="header">
  <div align="center"> <h1>Account</h1> </div>
<a>{{account.name}}</a>

<h1>www.Faeva.com</h1>
<!-- 原来这里的 <span>&#9661;</span> 是显示Icon， ok ， i am  -->
<div><a href="#" class="bt btmiddle"> anxing <span>&#9661;</span></a></div>


<div data-role="collapsible">
   <h4>Hi, {{user.name}}</h4>
   <ul data-role="listview">
     <li>
       <div width="5%">
         <a id="a_Members">Members</a>
       </div>
     </li>
     <li><div width="5%"><a id="a_profile">profile</a></div></li>
     <li><div width="5%"><a id="a_subscription">subscription</a></div></li>
     <li><div width="5%"><a id="a_logout">log out</a></div></li>
   </ul>
</div>
<a id="a_createApp">Creates App</a>
</div>
  <div data-role="content" class="content">

    <div id="menu">
        <div id="triangle"></div>
        <div id="tooltip_menu">
            <a href="#" class="menu_top" onClick="app_edit()">
                <span class="img img_setup icon icon-edit "></span>
                <b>Edit</b>
            </a>
            <a href="#" onClick="app_delete()">
                <span class="img img_del icon icon-delete"></span>
                <b>Delete</b>
            </a>
        </div>
    </div>
    {% if apps is empty %}
    {% else %}
      {% for app in apps %}
        <p>
          <div class="panel" id="">
            <div class="content">
              <div class="ui-grid-a">
               <div class="ui-block-a"><span class="app_name">{{app.name}}</span></div>
               <div class="ui-block-b"><span></span></div>
               <div class="ui-block-c" align="right"><span id="{{app.appId}}" class="img img_setup icon icon-add"></span></div>
               <div class="ui-block-d" align="right"><span id="{{app.appId}}" class="img img_del icon icon-delete"></span></div>
              </div>

              <div class="ui-grid-b">
               <div class="ui-block-a"> </div>
               <div class="ui-block-b"><span>{{app.desc}}</span></div>
               <div class="ui-block-c" align="right"></div>
              </div>

              <div class="ui-grid-c">
               <div class="ui-block-a">  </div>
               <div class="ui-block-b"><p><b>1</b> <span class="project">project</span><br>
                 <b>1 </b><span class="number">number</span></p></div>
               <div class="ui-block-c" align="right"></div>
              </div>
            </div>
          </div>
        </p>
      {% else %}
          There are no apps to show
      {% endfor %}
    {% endif %}
  </div>

  <div data-role="footer" data-position="fixed" data-fullscreen="true">
    <h1>我的底部</h1>
  </div>
</div>

</body>
</html>

<!-- <img src="http://www.zhituad.com/photo2/00/87/68/91b1OOOPIC4e.jpg" /> -->
