<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="http://apps.bdimg.com/libs/jquerymobile/1.4.2/jquery.mobile.min.css">
<script src="http://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/jquerymobile/1.4.2/jquery.mobile.min.js"></script>

<script>
  $(function(){
    $("#a_account").on("click",function(){
      location.href = "/Faeva2/account/account/home";
    });
  });
</script>

</head>
<body>

<div data-role="page">
<div data-role="header">
<h1>www.Faeva.com</h1>
    <div data-role="navbar">
      <ul>
        <li><a href="#" data-icon="home">主页Home</a></li>
        <li><a href="#" data-icon="star" id="a_account">
          {% if user.name is empty %}
              {{ "Account" }}
          {% else %}
              Hi, {{user.name}}
          {% endif %}
        </a></li>

        <li><a href="#" data-icon="search">搜索</a></li>
      </ul>
    </div>
  </div>

  <div data-role="content" align="center">
    <img src="http://www.zhituad.com/photo2/00/87/68/91b1OOOPIC4e.jpg" />
  </div>

  <div data-role="footer">
    <h1>我的底部</h1>
  </div>
</div>

</body>
</html>
