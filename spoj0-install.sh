#!/bin/bash
# Note: This Script should be run as root!

# INSTALL PACKAGES
apt-get install launchtool libapache2-mod-perl2 apache2 mysql-server mysql-client libdbi-perl libdbd-mysql-perl

# CREATE USERS
useradd --create-home --password spoj0 spoj0
useradd --create-home --password spoj0run spoj0run

# GET FROM REPO
SPOJ_GIT_REPO=https://github.com/dimitarminchev/spoj0.git
git clone $SPOJ_GIT_REPO
cp -r spoj0/ /home/
rm -r spoj0/

# HOME
cd /home/spoj0
chown -R spoj0:spoj0 .
chmod 755 *.pl
chmod 755 *.sh

# MYSQL
mysql -p < spoj0.sql

# APACHE
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
service apache2 reload

# START AND IMPORT SETS
./spoj0-control.pl start
./spoj0-control.pl import-set trivial

#27 - hello 28 - a+b
./spoj0-control.pl submit 27 5 ./test/hello_ok.java java hello_ok.java
./spoj0-control.pl submit 27 5 ./test/hello_pe.java java hello_pe.java
./spoj0-control.pl submit 27 5 ./test/hello_re.java java hello_re.java
./spoj0-control.pl submit 27 5 ./test/hello_tl.java java hello_tl.java
./spoj0-control.pl submit 27 5 ./test/hello_wa.java java hello_wa.java
./spoj0-control.pl submit 28 5 ./test/ab_ok.java java ab_ok.java
./spoj0-control.pl submit 27 5 ./test/hello_ok.cpp cpp hello_ok.cpp
./spoj0-control.pl submit 27 5 ./test/hello_pe.cpp cpp hello_pe.cpp
./spoj0-control.pl submit 28 5 ./test/ab_ok.cpp cpp ab_ok.cpp
./spoj0-control.pl submit 28 5 ./test/ab_pe.cpp cpp ab_pe.cpp
./spoj0-control.pl submit 28 5 ./test/ab_wa.cpp cpp ab_wa.cpp
