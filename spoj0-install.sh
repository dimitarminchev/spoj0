#!/bin/bash 

# COLORS
nocol="\e[0m"
green="\e[1;32m"	
yellow="\e[1;33m"	
red="\e[1;31m"	

# TERMINAL BREAK (CTRL+C)
trap 'printf "\n${red}INSTALLATION TERMINATED!${nocol}\n"; exit 1' 2

# QUESTION
printf "${yellow}DO YOU WANT TO START? (yes/no) ${nocol}"
read answer
if [ $answer = "no" ]; then
   printf "${red}INSTALLATION TERMINATED!${nocol}\n"
   exit 1 # EXIT
fi

# INSTALL PACKAGES
printf "${green}INSTALL PACKAGES ...\n${nocol}"
apt-get update
apt-get install php php-mcrypt php-mysql apache2 libapache2-mod-php libapache2-mod-perl2 mysql-server mysql-client libdbi-perl libdbd-mysql-perl launchtool default-jdk g++ mono-mcs --fix-missing

# CREATE USERS
printf "${green}CREATE USERS ...\n${nocol}"
useradd --create-home --password spoj0 spoj0
useradd --create-home --password spoj0run spoj0run
printf "DONE.\n"

# GET FROM REPO
printf "${green}GET FROM REPO ...\n${nocol}"
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
printf "${green}MYSQL ...\n${nocol}"
printf "${yellow}ENTER MYSQL ROOT USER PASSWORD\n${nocol}"
mysql -u root -p < spoj0.sql

# APACHE
printf "${green}APACHE ...\n${nocol}"
cat <<EOT > /etc/apache2/sites-available/spoj0.conf
Alias /spoj /home/spoj0/web
<Directory /home/spoj0/web>
Options MultiViews Indexes Includes FollowSymLinks ExecCGI
AllowOverride All
Require all granted
allow from all
</Directory>
EOT
a2ensite spoj0.conf
service apache2 reload

# SPOJ 
printf "${green}SPOJ ...\n${nocol}"
now=$(date +"%Y-%m-%d %H:00:00")
cat << EOT  > /home/spoj0/sets/test/set-info.conf
name=TEST
start_time=$now
duration=60
show_sources=1
about=SELF TEST
EOT

# RUN AND IMPORT TEST SET
./spoj0-control.pl start
./spoj0-control.pl import-set test

# SAMPLE SUBMITS
# milo
./spoj0-control.pl submit 1 3 sets/test.samples/hello_pe.java java hello_pe.java
./spoj0-control.pl submit 1 3 sets/test.samples/hello_re.java java hello_re.java
./spoj0-control.pl submit 1 3 sets/test.samples/hello_tl.java java hello_tl.java
./spoj0-control.pl submit 1 3 sets/test.samples/hello_wa.java java hello_wa.java
./spoj0-control.pl submit 1 3 sets/test.samples/hello_ok.java java hello_ok.java
./spoj0-control.pl submit 1 3 sets/test.samples/hello_pe.cpp cpp hello_pe.cpp
./spoj0-control.pl submit 1 3 sets/test.samples/hello_ok.cpp cpp hello_ok.cpp
./spoj0-control.pl submit 2 3 sets/test.samples/ab_ok.java java ab_ok.java
./spoj0-control.pl submit 2 3 sets/test.samples/ab_pe.cpp cpp ab_pe.cpp
./spoj0-control.pl submit 2 3 sets/test.samples/ab_wa.cpp cpp ab_wa.cpp
./spoj0-control.pl submit 2 3 sets/test.samples/ab_ok.cpp cpp ab_ok.cpp
# mitko
./spoj0-control.pl submit 1 4 sets/test.samples/ab_ok.cs cs ab_ok.cs
./spoj0-control.pl submit 1 4 sets/test.samples/hello_ok.cs cs hello_ok.cs
./spoj0-control.pl submit 2 4 sets/test.samples/hello_ok.cs cs hello_ok.cs
./spoj0-control.pl submit 2 4 sets/test.samples/ab_ok.cs cs ab_ok.cs

# DONE
printf "${green}ENJOY SPOJ!${nocol}\n"
