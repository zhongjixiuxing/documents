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