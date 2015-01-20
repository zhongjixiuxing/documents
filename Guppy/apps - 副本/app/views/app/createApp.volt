

<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title> 用户登录 </title>



<script type="text/javascript">
    var showMenu = false;

    function MyClick(){
      if(showMenu){
        showMenu = false;
      }else{
        showMenu = true;
      }
    }
</script>
 </head>

  <body>
  <div align="center">
    <form action="/Faeva2/app/app/createApp" method="post">
      <p> <h1>app name : </h1><br>
      <textarea  name="name" clos="20" rows="5"> </textarea>
      <br>
      <p><h1>app description :<h1><br>
      <textarea  name="desc" clos="20" rows="5"> </textarea>
      <br>
      <input type="submit" value="submit" />
  </div>
  </body>
</html>
