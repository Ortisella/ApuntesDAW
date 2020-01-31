- Archivo de configuracion de la red en CentOs
```
sudo vi /etc/sysconfig/network-scripts/ifcfg-enp<TAB>
```

- Comandos de vi
```
i = insertar
:wq = guardar y salir
```

- Reiniciar el servicio de internet
```
sudo service network restart
```

- Instalar apache
```
sudo yum install httpd
```

- Se pregunta por el estado del servicio apache
```
systemctl status httpd
```

- Iniciar el servicio apache
```
sudo systemctl start httpd 
```

- Apagar la maquina virtual
```
sudo shutdown 
```

- Atención:
```
Adaptador puente para simular que la maquina virtual es otro ordenador conectado a la red
```

- Comprobar direccion IP
```
ip addr show
```
- Conectar con ssh
```
ssh victor@ip
```
- Añadir regla firewall
```
sudo firewall-cmd --zone=public --add-service=http --permanent  
sudo firewall-cmd --add-port=8080/tcp --permanent
sudo firewall-cmd --reload = recarga el firewall
```

- Saber la version de linux
```
cat /etc/*-release
```

- Parar el servidor de apache
```
sudo apachectl stop 
```

- Iniciar el servicio de apache
```
sudo apachectl start 
```

- Reiniciar el servicio de apache
```
sudo apachectl restart  
```

- Reiniciar el servicio de apache cuando todo el mundo termine sus tareas
```
sudo apachectl graceful
```
- Ver estado de apache 
```
apachectl status 
```

- Habilitar para que el apache se inicie al reiniciar el servidor
```
sudo systemctl enable httpd 
```

- Instalar el manual de apache
```
sudo yum install httpd-manual 
```

- Reiniciar apache para ver el manual
```
sudo apachectl restart 
```

- Info version corta de apache
```
httpd -v 
```

- Info version larga de apache
```
httpd -V 
```

- Para modificar el host
```
sudo nano /etc/hosts 
```

- Instalar nano
```
sudo yum install nano 
```

- Cambiar el nombre del servidor
```
sudo nano /etc/hostname 
```

- Ver directorios
```
ll /etc/httpd 
```

- Archivo de configuracion
```
sudo nano /etc/httpd/conf/httpd.conf 
```

- Poner la ip estatica
```
BOOTPROTO=static
IPADDR=192.168.1 y la ip que recibamos
NETMASK=255.255.255.0
GATEWAY=192.168.1.2
DNS1=8.8.8.8
DNS2=8.8.4.4
```

- Para pasar archivos de local al servidor
```
scp ./web_daw.zip victor@servidor:/home/victor/Descargas/web_daw.zip 
```

- Crear carpeta en /var/www
```
sudo mkdir /var/www/carpeta 
```

- Copia un archivo a otro directorio
```
sudo cp -R web_daw/* /var/www/carpeta 
```

- Permisos:
```
644 (rw-r--r--) para archivos
755 (rwxr-xr-x) para carpetas
```

- Archivo de configuracion para la carpeta creada anteriormente
```
sudo nano /etc/httpd/conf.d/carpeta.conf 
```
```
* -> Todos
192.168.1. ip -> para que solo acceda a esa ruta
<VirtualHost *:80>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
</VirtualHost>
```

- Comprobar la configuracion de apache
```
sudo apachectl configtest 
```

- Para que escuche en el puerto 8080
```
Listen 8080
<VirtualHost *:8080>
    DocumentRoot /var/www/trabajadores
    ServerName trabajadores.com
</VirtualHost>
```

- Para ver los modulos de apache
```
httpd -M 
```

- Instalar php
```
sudo yum install epel-release yum-utils
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm

sudo yum-config-manager --enable remi-php72
sudo yum install php php-common php-opcache php-mcrypt php-cli
sudo yum install php-gd php-curl php-mysqlnd
```

- Instalar MariaDB / Mysql
```
sudo yum install mariadb mariadb-server
```

- Preguntar por el estado de mariadb
```
sudo systemctl status mariadb 
```

- Iniciar el servicio mariadb al arrancar el servidor
```
sudo systemctl enable mariadb 
```
- Para la seguridad de mariadb
```
sudo mysql_secure_installation 
```

- Entrar en mysql
```
mysql -u root -p 
```

- Instalar phpMyAdmin
```
sudo yum install php-pecl-zip php-mbstring
sudo yum install phpmyadmin
```
- Hacer visible en todas las ips para phpmyadmin
```
#     <RequireAny>
#       Require ip 127.0.0.1
#       Require ip ::1
#     </RequireAny>
   Require all granted
```

