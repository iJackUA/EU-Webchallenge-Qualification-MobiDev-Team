#!/usr/bin/env bash

apt-get update
apt-get install -y python-software-properties curl

# you can get latest php like this
add-apt-repository ppa:ondrej/php5

# or nodejs like this
curl -sL https://deb.nodesource.com/setup | sudo bash -

# or rvm/ruby like this
# gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3
# curl -L https://get.rvm.io | bash -s stable --ruby
# source /usr/local/rvm/scripts/rvm

# now lets install it along with nginx
apt-get -q -y install nodejs php5 php5-cli php5-fpm php5-pgsql nginx postgresql postgresql-contrib

# configure postgresql
sudo -u postgres psql -c "CREATE USER euweb WITH PASSWORD 'euweb';"
sudo -u postgres createdb -E UTF8 -T template0 --locale=en_US.utf8 euweb_db;
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE euweb_db to euweb;"

# link project folder
rm -rf /var/www /usr/share/nginx/www
ln -s /vagrant /var/www
ln -s /vagrant /usr/share/nginx/www

# copy config
cat /vagrant/provision/config/default.conf > /etc/nginx/sites-available/default
cat /vagrant/provision/config/php.ini > /etc/php5/php.ini

# TODO: delete oauth token after qualification
# install composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
/bin/su -c 'composer config -g github-oauth.github.com ecc3b6373489b5dc23013fa7f09cd8c802465b07' vagrant
/bin/su -c 'composer global require "fxp/composer-asset-plugin:~1.0.3"' vagrant

# restart server
/etc/init.d/nginx restart
service php5-fpm restart

# setup app
# run composer update
cd /vagrant
/bin/su -c 'composer update --prefer-dist --optimize-autoloader' vagrant

# run migrations
/bin/su -c './yii migrate --interactive=0' vagrant
