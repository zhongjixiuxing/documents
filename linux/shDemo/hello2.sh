#!/bin/bash


# get string len 
 string="anxing";
 echo "string len : ${#string}"

# substring 
 string="alibaba is a great company"
 echo "substring is : "${string:1:4}

# define array and get array ele
 array_name=(anxing1 value1 anxing2 value3)
 # or 
 array_name=(
 anxing1
 value1
 anxing2
 value3
 )

 echo -e "array 3 index is : ${array_name[3]}";
 echo -e "array print all ele : ${array_name[*]}";
 echo -e "array print all ele 2 : ${array_name[@]}";
 
 #get array length
 echo "array length is : ${#array_name[*]}";
 echo "array length is 2 : ${#array_name[@]}";


# is else if 
a=10
b=20
if [ $a == $b ]
then
   echo "a is equal to b"
elif [ $a -gt $b ]
then
   echo "a is greater than b"
elif [ $a -lt $b ]
then
   echo "a is less than b"
else
   echo "None of the condition met"
fi


# test 命令用于检查某个条件是否成立，与方括号([ ])类似。
num1=$[2*3]
num2=$[1+5]
if test ${num1} -eq ${num2}
then
    echo 'The two numbers are equal!'
else
    echo 'The two numbers are not equal!'
fi



# switch case 
echo 'Input a number between 1 to 4'
echo 'Your number is:\c'
read aNum
case $aNum in
    1)  echo 'You select 1'
        ;;
    2)  echo 'You select 2'
        ;;
    3)  echo 'You select 3'
        ;;
    4)  echo 'You select 4'
        ;;
    *)  echo 'You do not select a number between 1 to 4'
        ;;
esac


# for 
for loop in 1 2 3 4 5
do
    echo "The value is: $loop"
done
 
#显示用户家目录下面所有的.bash结尾的文件
for FILE in $HOME/.bash*
do
   echo $FILE
done


# while 跳出循环是使用break \ continue 一样的
COUNTER=0
while [ ${COUNTER} -lt 5 ]
do
    COUNTER=`expr $COUNTER + 1`;
    echo $COUNTER
done

#function 
func1(){
 echo "param : $1";
 func2;
}

func2(){
 echo "func2... ";
}

func1 "anxing";

who > users;


# 下面的代码比较有意思，直接操作vi 编辑text
# 这里涉及到一个here概念，就是将下面EndOfCommands的指令代码重定向到 前面。 nb
filename=test.txt
vi $filename <<EndOfCommands
i
This file was created automatically from
a shell script
^[
ZZ
EndOfCommands
