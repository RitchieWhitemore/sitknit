#!/usr/bin/env bash

#== Import script args ==

timezone=$(echo "$1")

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

#info "Prepare root password for MySQL"
#debconf-set-selections <<< "mariadb-server-10.0 mysql-server/root_password password \"''\""
#debconf-set-selections <<< "mariadb-server-10.0 mysql-server/root_password_again password \"''\""
#echo "Done!"

info "Update OS software"
apt-add-repository ppa:ondrej/php
apt-get update
apt-get upgrade -y

info "Install additional software"
#apt-get install -y php7.0-curl php7.0-cli php7.0-intl php7.0-mysqlnd php7.0-gd php7.0-fpm php7.0-mbstring php7.0-xml unzip mariadb-server-10.0 php.xdebug


apt-get install -y apache2 php7.1 php.xdebug mysql-server php7.1-mysql


info "Configure MySQL"
#sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
mysql -uroot <<< "CREATE USER 'root'@'%' IDENTIFIED BY ''"
mysql -uroot <<< "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%'"
mysql -uroot <<< "DROP USER 'root'@'localhost'"
mysql -uroot <<< "FLUSH PRIVILEGES"
echo "Done!"

#info "Configure PHP-FPM"
#sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
#sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
#sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.0/fpm/pool.d/www.conf
cat << EOF > /etc/php/7.1/mods-available/xdebug.ini
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=1
EOF
echo "Done!"

#info "Configure NGINX"
#sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
#echo "Done!"

#info "Enabling site configuration"
#ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
#echo "Done!"

apt-get install -y apache2
# Remove /var/www default
#rm -rf /var/www
# Symlink /vagrant to /var/www
#ln -fs /app /var/www
# Add ServerName to httpd.conf
#echo "ServerName localhost" > /etc/apache2/httpd.conf
# Setup hosts file
#VHOST=$(cat <<EOF
#<VirtualHost *:80>
#  DocumentRoot "/app"
#  ServerName localhost
#  <Directory "/app">
#    AllowOverride All
#  </Directory>
#</VirtualHost>
#EOF
#)
#echo "${VHOST}" > /etc/apache2/sites-enabled/000-default
# Enable mod_rewrite
a2enmod rewrite
# Restart apache
service apache2 restart

info "Initailize databases for MySQL"
mysql -uroot <<< "CREATE DATABASE sitknit"
mysql -uroot <<< "CREATE DATABASE sitknit_test"
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer