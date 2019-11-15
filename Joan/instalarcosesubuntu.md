sudo apt install php libapache2-mod-php php-mysql
sudo apt install mariadb-server
sudo mysql_secure_installation (poner contraseña para root, luego si a todo)
sudo mysql -u root -p (aquí comprovar las dbs existentes [show DATABASES;], para salir quit)

instalar phpMyAdmin
sudo apt install phpmyadmin

si hi ha problemes amb phpMyAdmin:
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo ln -s /etc/apache2/conf-available/phpmyadmin.conf /etc/apache/conf-enabled/phpmyadmin.conf
sudo a2ensite phpmyadmin
