	前言：哎，终于写完这些基本的配置文件，也不知道自己一个人写的东西符合boss的要求不，剩下的让我感到也是慢慢调试...
		--》php
		--》angular
		--》mongo
		--》html5

1、将json2.php、testTable.php、MongoDBUtil.php、config.php、UUIDUtils.php文件复制到你项目的根目录下

2、打开config.php
	--》将$MongoPath 改成要操作Mongo数据库路径，如果Mongo数据库不是运行默认端口27017下，请在后面加上对应的端口号
	--》将$db_name 改成你要操作的数据库名
	--》将$table_name 改成您要操作的文档（既是表)
	--》将$project_name 改成你当前的项目名
	--》将$web_path 改成你web服务器的地址

3、在浏览器输入url :  http://你开放的web服务地址/项目名/testTable.php
	回车即可看到你对应Mongo中的文档数据


	
特别声明：由于本人的水平麻麻地，目前该版本只支持字符串数据类型，其他的数字、日期等都不支持，将在下一个版本改进；
	@AnXing 2014/11/23
 
