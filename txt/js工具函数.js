	/**
	*	���������صĽ����ʵ�����ĸת��д�Ĺ���
	*   	���Կ���ʹ��
	*/
	function ReplaceFirstUper(str)
	{   
		str = str.toLowerCase();   
		return str.replace(/\b(\w)|\s(\w)/g, function(m){
			return m.toUpperCase();
		});  
	}

	//������ĸתΪСд
	function toLocaleLowerCase(str){
		str.trim();
		c = str.substring(0,1);
		c = c.toLocaleLowerCase();
		str = str.substring(1,str.length);
		str = c+str;
		return str;
	}

	//��ӡ���� 
	function dump_obj(myObject){ 
		  var s = ""; 
		  for (var property in myObject) { 
		   s = s + "\n "+property +": " + myObject[property] ; 
		  } 
		  alert(s); 
	} 

	/**
	* 	����ʹ��jquery��json�ַ���ת����json�������� 
	*/
	function ConvertToJsonForJq() {  
	    
	    var testJson = '[{"name": "Сǿ", "age": 16 },{"name": "����", "age": 21}]';   
	    testJson = $.parseJSON(testJson);  
	    for(var x=0; x<testJson.length; x++){
		alert("name : "+testJson[x]["name"]);
	    }
	};