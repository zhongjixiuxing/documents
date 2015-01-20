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
<?php
  $name = $_GET['name'];
  $action = $_GET['action'];
  $pid = $_GET['pid'];
  $oid = $_GET['oid'];

?>
  权限更改
  <br>
  <form class="form-inline definewidth m20" action="/faeva.com/user/power/editOption/<?php echo $pid."/".$oid; ?>"
    method="post">

    <ul>
    <li>name： <input type="text" name="name" id="name"
      class="abc input-default" placeholder="" value="<?php echo $name; ?>"><br>
    <li>controller： <input type="text" name="action" id="action"
      class="abc input-default" placeholder="" value="<?php echo $action; ?>"><br>

  </ul>
      &nbsp;&nbsp;
    <button type="submit" class="btn btn-primary">保存</button>
    &nbsp;&nbsp;
  </form>

</body>
</html>
