#!/bin/bash


#author anxing


# 定义只读变量，相当于全局变量
 ROOTPATH="/var/www/html";
 readonly ROOTPATH;
 echo "root path : $ROOTPATH"; 

# unset
 ROOTPAXX="SDFSDFSDF";
 unset ROOTPAXX
 echo $ROOTPAXX


# read stdin
 echo "what is your name"
 read Name
 if [ ! $Name ]; then 
	echo "is Null ";
        echo "your name is null " >> ./hel.txt;
 else 
 	echo "Hello $Name";
 fi

 
# get current shell pid
 echo $$

# display special var
 echo "current filename : $0";
 echo "current first paramter : $1";
 echo "current secode paramter : $2";
 echo "current paramter size : $#";
 echo "current all paramter : $*";
 echo "current all paramter2 : $@";
 echo "last commond execute status : $?";


#get execute command result 
 Date=`date`;
 echo -e "\n date is : ${Date}";

##############################################变量替换
 # 如果变量 var 为空或已被删除(unset)，那么返回 word，但不改变 var 的值。
 echo -e "\n if var is no set or exist , then will return : ${var:-hello}";

 # 如果变量 var 为空或已被删除(unset)，那么返回 word，并将 var 的值设置为 word。 
 echo -e "\n if var is no set or exist , then var will be set a val and return ${var:=hello}";


#算术运算符
a=10
b=20
val=`expr $a + $b`
echo "a + b : $val"
val=`expr $a - $b`
echo "a - b : $val"
val=`expr $a \* $b`
echo "a * b : $val"
val=`expr $b / $a`
echo "b / a : $val"
val=`expr $b % $a`
echo "b % a : $val"
if [ $a == $b ]
then
   echo "a is equal to b"
fi
if [ $a != $b ]
then
   echo "a is not equal to b"
fi

echo -e "\n";

# 关系运算符
a=10
b=20
if [ $a -eq $b ]
then
   echo "$a -eq $b : a is equal to b"
else
   echo "$a -eq $b: a is not equal to b"
fi
if [ $a -ne $b ]
then
   echo "$a -ne $b: a is not equal to b"
else
   echo "$a -ne $b : a is equal to b"
fi
if [ $a -gt $b ]
then
   echo "$a -gt $b: a is greater than b"
else
   echo "$a -gt $b: a is not greater than b"
fi
if [ $a -lt $b ]
then
   echo "$a -lt $b: a is less than b"
else
   echo "$a -lt $b: a is not less than b"
fi
if [ $a -ge $b ]
then
   echo "$a -ge $b: a is greater or  equal to b"
else
   echo "$a -ge $b: a is not greater or equal to b"
fi
if [ $a -le $b ]
then
   echo "$a -le $b: a is less or  equal to b"
else
   echo "$a -le $b: a is not less or equal to b"
fi


# 字符串运算符
a="abc"
b="efg"
if [ $a = $b ]
then
   echo -e "\n $a = $b : a is equal to b"
else
   echo "$a = $b: a is not equal to b"
fi
if [ $a != $b ]
then
   echo "$a != $b : a is not equal to b"
else
   echo "$a != $b: a is equal to b"
fi
if [ -z $a ]
then
   echo "-z $a : string length is zero"
else
   echo "-z $a : string length is not zero"
fi
if [ -n $a ]
then
   echo "-n $a : string length is not zero"
else
   echo "-n $a : string length is zero"
fi
if [ $a ]
then
   echo "$a : string is not empty"
else
   echo "$a : string is empty"
fi

# c常用文件操作
file="/var/www/tutorialspoint/unix/test.sh"
if [ -r $file ]
then
   echo "File has read access"
else
   echo "File does not have read access"
fi
if [ -w $file ]
then
   echo "File has write permission"
else
   echo "File does not have write permission"
fi
if [ -x $file ]
then
   echo "File has execute permission"
else
   echo "File does not have execute permission"
fi
if [ -f $file ]
then
   echo "File is an ordinary file"
else
   echo "This is sepcial file"
fi
if [ -d $file ]
then
   echo "File is a directory"
else
   echo "This is not a directory"
fi
if [ -s $file ]
then
   echo "File size is zero"
else
   echo "File size is not zero"
fi
if [ -e $file ]
then
   echo "File exists"
else
   echo "File does not exist"
fi


 var1="anxing1";
 var2="anixng2";
 var=${var1}${var2};
 echo -e "\n var : ${var}";
