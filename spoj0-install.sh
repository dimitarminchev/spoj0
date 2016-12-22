#!/bin/bash
# Note: This Script should be run as root!

# Install packages
echo "INSTALL PACKAGES..."
apt-get install launchtool libapache2-mod-perl2 apache2 mysql-server mysql-client libdbi-perl libdbd-mysql-perl
echo "Enter to continue..."
read

# Create users
echo "CREATE USERS..."
useradd --create-home --password spoj0 spoj0
useradd --create-home --password spoj0run spoj0run
echo "Enter to continue..."
read

# Get from repository
echo "GET FROM REPO..."
SPOJ_GIT_REPO=https://github.com/dimitarminchev/spoj0.git
git clone $SPOJ_GIT_REPO
cp -r spoj0/ /home/
# rm -r spoj0/
echo "Enter to continue..."
read

# Back home
cd /home/spoj0

# Owner and Permissions
chown -R spoj0:spoj0 .
chmod 755 *.pl
chmod 755 *.sh

# MySQL
echo "MYSQL..."
mysql -p < spoj0.sql
echo "Enter to continue..."
read

# Apache
echo "APACHE..."
cat <<EOT > /etc/apache2/sites-available/spoj0.conf
Alias /spoj /home/spoj0/web2
<Directory /home/spoj0/web2>
Options MultiViews Indexes Includes FollowSymLinks ExecCGI
AllowOverride All
Require all granted
allow from all
</Directory>
EOT
a2ensite spoj0.conf
service apache2 fource-reload
echo "Enter to continue..."
read


# Run
# echo "Run..."
#./spoj0-control.pl start

# Import Sets
# TODO
