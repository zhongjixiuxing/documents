<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../Css/bootstrap.css" />
<link rel="stylesheet" type="text/css"
  href="../Css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="../Css/style.css" />
<script type="text/javascript" src="../Js/jquery.js"></script>
<script type="text/javascript" src="../Js/jquery.sorted.js"></script>
<script type="text/javascript" src="../Js/bootstrap.js"></script>
<script type="text/javascript" src="../Js/ckform.js"></script>
<script type="text/javascript" src="../Js/common.js"></script>

<style type="text/css">
body {
  padding-bottom: 40px;
}

.sidebar-nav {
  padding: 9px 0;
}

@media ( max-width : 980px) {
  /* Enable use of floated navbar text */
  .navbar-text.pull-right {
    float: none;
    padding-left: 5px;
    padding-right: 5px;
  }
}
</style>
</head>
<body>

  权限增添
  <br>
  <form class="form-inline definewidth m20" action="/faeva.com/user/power/add"
    method="post">
    <ul>
    <li>权限名称： <input type="text" name="powername" id="powername"
      class="abc input-default" placeholder="" value=""><br>
    <li>controller： <input type="text" name="controller" id="controller"
      class="abc input-default" placeholder="" value=""><br>

    <li> option:&nbsp; &nbsp; &nbsp; &nbsp; <br>
    </li>

    <ul>
      <li>-->name： <input type="text" name="name" id="name"
        class="abc input-default" placeholder="" value=""><br>

      <li>-->action： <input type="text" name="action" id="action"
        class="abc input-default" placeholder="" value=""><br>

    </ul>
  </ul>
      &nbsp;&nbsp;
    <button type="submit" class="btn btn-primary">保存</button>
    &nbsp;&nbsp;
  </form>

</body>
</html>
