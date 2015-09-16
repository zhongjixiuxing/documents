#Version 0.0.1
FROM docker.io/centos

#维护人员信息
MAINTAINER anxing "1965198272@qq.com"

#ifconfig comman
RUN yum install -y net-tools

#apache
#RUN yum install -y httpd

#开放80端口
#EXPOSE 80
#EXPOSE 22

#初始化httpd
#ENTRYPOINT service httpd start

RUN         yum install -y openssh openssh-server openssh-clients
RUN         mkdir /var/run/sshd
RUN         ssh-keygen -t rsa -f /etc/ssh/ssh_host_rsa_key
RUN         ssh-keygen -t dsa -f /etc/ssh/ssh_host_dsa_key
RUN         /bin/echo 'root:aaaaaa' |chpasswd
RUN         useradd liu
RUN         /bin/echo 'liu:aaaaaa' |chpasswd
RUN         /bin/sed -i 's/.*session.*required.*pam_loginuid.so.*/session optional pam_loginuid.so/g' /etc/pam.d/sshd
RUN         /bin/echo -e "LANG=\"en_US.UTF-8\"" > /etc/default/local
EXPOSE      22
CMD         /usr/sbin/sshd -D

