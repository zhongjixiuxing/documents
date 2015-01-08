	/**
	*	从网上下载的将单词的首字母转大写的功能
	*   	测试可以使用
	*/
	function ReplaceFirstUper(str)
	{   
		str = str.toLowerCase();   
		return str.replace(/\b(\w)|\s(\w)/g, function(m){
			return m.toUpperCase();
		});  
	}

	//将首字母转为小写
	function toLocaleLowerCase(str){
		str.trim();
		c = str.substring(0,1);
		c = c.toLocaleLowerCase();
		str = str.substring(1,str.length);
		str = c+str;
		return str;
	}

	//打印对象 
	function dump_obj(myObject){ 
		  var s = ""; 
		  for (var property in myObject) { 
		   s = s + "\n "+property +": " + myObject[property] ; 
		  } 
		  alert(s); 
	} 

	/**
	* 	测试使用jquery将json字符串转换成json对象数组 
	*/
	function ConvertToJsonForJq() {  
	    
	    var testJson = '[{"name": "小强", "age": 16 },{"name": "张三", "age": 21}]';   
	    testJson = $.parseJSON(testJson);  
	    for(var x=0; x<testJson.length; x++){
		alert("name : "+testJson[x]["name"]);
	    }
	};

	/*弹出输入框*/
	function prom() {  
        	var name = prompt("请输入您的名字", ""); //将输入的内容赋给变量 name ，  
  		//这里需要注意的是，prompt有两个参数，前面是提示的话，后面是当对话框出来后，在对话框里的默认值  
        	if (name)//如果返回的有内容  
        	{  
          	 alert("欢迎您：" + name)  
        	}  
  
    	}
