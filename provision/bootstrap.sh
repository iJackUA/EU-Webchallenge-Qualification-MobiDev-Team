#!/usr/bin/env bash

apt-get update
apt-get install -y python-software-properties curl

# you can get latest php like this
add-apt-repository ppa:ondrej/php5

# or nodejs like this
curl -sL https://deb.nodesource.com/setup | sudo bash -

# or rvm/ruby like this
gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3
curl -L https://get.rvm.io | bash -s stable --ruby
source /usr/local/rvm/scripts/rvm

# now lets install it along with nginx
apt-get -q -y install nodejs php5 php5-cli php5-fpm nginx

rm -rf /var/www /usr/share/nginx/www
ln -s /vagrant /var/www
ln -s /vagrant /usr/share/nginx/www

cat /vagrant/provision/config/default.conf > /etc/nginx/sites-available/default

/etc/init.d/nginx restart