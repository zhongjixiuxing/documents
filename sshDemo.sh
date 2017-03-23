#!/bin/sh

le_exe=/user/bin/letsencrypt/letsencrypt-auto
le_key_path=/etc/letsencrypt/live
www_key_path=/var/wwwkeys

if [ "$1" = "new" -a "$#" -ge 2 ]; then
        cmd="$le_exe certonly --manual -d $2"
        #cmd="$le_exe certonly --manual -d $2 -d www.$2"
elif [ "$1" = "renew" ]; then
        cmd="$le_exe renew"
elif [ "$1" = "install" -a "$#" -ge 3 ]; then
        cmd="install_certs_on_server $2 $3 $4"
else
        echo "SYNTAX#1: $0 new DOMAIN_NAME" >&2
        echo "EG#1: $0 new faeava.cn" >&2
        echo "SYNTAX#2: $0 renew" >&2
        echo "EG#2: $0 renew" >&2
        echo "SYNTAX#3: $0 install SERVER_PEM_FILE DOMAIN_NAME [apache|nginx]" >&2
        echo "EG#3: $0 install /user/home.ssh/axpeng.cn.pem faaevaa.cn" >&2
        echo "EG#3: $0 install /user/home.ssh/axpeng.cn.pem faeavaa.cn apache" >&2
        exit 1
fi

function install_certs_on_server() {
        server_key=$1
        domain=$2
        server_type=$3
        echo "1. privkey.pem：安全证书的key文件（也就是Apache中的SSLCertificateKeyFile和Nginx的ssl_certificate_key）
              2. cert.pem：Apache的服务器端证书（Apache的SSLCertificateFile）
              3. chain.pem：Apache的根证书和中继证书（Apache的SSLCertificateChainFile）
              4. fullchain.pem：所有证书（Nginx所需要的ssl_certificate）
        " > "$le_key_path/$domain/README.TXT"
        c1="scp -i $server_key -r $le_key_path/$domain ec2-user@$domain:/home/ec2-user"
        echo $c1
        $c1
        c1="ssh -i $server_key ec2-user@$domain \"\"sudo mkdir $www_key_path; sudo chown -R root:root $domain && sudo chmod -R go-rwx $domain && sudo rm -rf $www_key_path/$domain && sudo mv $domain $www_key_path\"\""
        echo $c1
        $c1
        if [ "$server_type" = "apache" ]; then
                c1="ssh -i $server_key username@$domain \"\"sudo service httpd restart\"\""
        elif [ "$server_type" = "nginx" ]; then
                c1="ssh -i $server_key username@$domain \"\"sudo service nginx reload\"\""
        else
                echo "NO WEBSERVER TO RESTART" >&2
                exit 2
        fi
        echo $c1
        $c1
}
