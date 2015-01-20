<?php

require_once("../global/PHPMailer_v5.1/class.phpmailer.php");

class Email{
	private static $mail;
	function __construct(){
		self::$mail = new PHPMailer();  //实例化
		self::$mail->IsSMTP(); // 启用SMTP
		self::$mail->Host = "smtp.163.com"; //SMTP服务器 以163邮箱为例子
		self::$mail->Port = 25;  //邮件发送端口
		self::$mail->SMTPAuth   = true;  //启用SMTP认证

		self::$mail->CharSet  = "UTF-8"; //字符集
		self::$mail->Encoding = "base64"; //编码方式

		self::$mail->Username = "anxing131@163.com";  //你的邮箱
		self::$mail->Password = "6143254361";  //你的密码
		self::$mail->Subject = "你好"; //邮件标题

		self::$mail->From = "anxing131@163.com";  //发件人地址（也就是你的邮箱）
		self::$mail->FromName = "AnXing";  //发件人姓名
	}

	/**
	 * 发送邮件
	 * Enter description here ...
	 * @param unknown_type $address 收件人email
	 * @param unknown_type $username 收件人名称
	 * @param unknown_type $validateCode 用户激活的校验码
	 */
	public static function send($address, $username, $validateCode){
		self::$mail->AddAddress($address, "亲");//添加收件人（地址，昵称）
	 	self::$mail->IsHTML(true); //支持html格式内容

	 	//$mail->AddAttachment('xx.xls','我的附件.xls'); // 添加附件,并指定名称
		//$mail->AddEmbeddedImage("logo.jpg", "my-attach", "logo.jpg"); //设置邮件中的图片
		//$mail->Body = '你好, <b>朋友</b>! <br/>这是一封来自<a href="http://www.helloweba.com"
		//target="_blank">helloweba.com</a>的邮件！<br/>
		//<img alt="helloweba" src="cid:my-attach">'; //邮件主体内容

		self::$mail->Body = "亲爱的".$username."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
	    	　　<a href='http://anxing.wicp.net/Faeva/user/user/active/$validateCode' target=
			'_blank'>http://anxing.wicp.net/Faeva/user/user/active/$validateCode</a><br/>　　
	    		如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";  //邮件主体内容

		//发送
		if(!self::$mail->Send()) {
		  echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		  echo "Message sent!";
		}
	}

	public static function sendToUser($user){
		self::send($user->email, $user->name,$user->_id);
	}

	public static function sendUpdatePwd($user, $vCode){
		$UserId = $user['UserId'];
		$UserName = $user['loginname'];
		self::$mail->AddAddress($user['email'], "亲");//添加收件人（地址，昵称）
		self::$mail->IsHTML(true); //支持html格式内容

		self::$mail->Body = "亲爱的用户 $UserName ：您好！<br>
							请点击下面链接完成更改密码：
								<a href=\"https://localhost/Guppy/user/appUser/updatePwdByEmail_steps2/$UserId/$vCode\"> https://localhost/Guppy/user/appUser/updatePwdByEmail_steps2/$UserId/$vCode </a> <br>
							Faeva - This is a legendary company!<br>
							用户服务支持：1965198272@qq.com<br>";

		//发送
		if(!self::$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
	}
}

?>
