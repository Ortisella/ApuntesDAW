- Directorio de configuracion de red
```
/etc/netplan
```

- Archivo de configuracion de red
```
sudo nano /etc/netplan/50-cloud-init.yaml
```

- Poner ip estatica
```
network:
    ethernets:
        enp0s3:
#            dhcp4: true
            addresses: [192.168.1.169/24]
            gateway4: 192.168.1.2
            dhcp4: no 
            nameservers:
                addresses: [8.8.8.8,8.8.4.4]
            optional: true
        enp0s8:
    version: 2
```

- Aplica la configuracion de red
```
sudo netplan apply
```

- Devuelve el estado del firewall
```
sudo ufw status
```

- Devuelve mas informacion del estado de firewall
```
sudo ufw status verbose
```

- Habilitar firewall
```
sudo ufw enable
```

- Muestra la lista de aplicacion permitidas en el firewall
```
sudo ufw app list
```

- Instalar apache
```
sudo apt install apache2
```

- Comprobar estado de apache
```
systemctl status apache2
```

- Parar apache
```
sudo apachectl stop
```

- Iniciar apache
```
sudo apachectl start
```

- Reiniciar apache
```
sudo apachectl restart
```

-  Reiniciar apache esperando a que se termine las tareas de los usuarios
```
sudo apachectl graceful
```

- Permitir el puerto 80
```
sudo ufw allow 'Apache'
```

- Para añadir un puerto modificar el archivo
```
ports.conf
```

- Ver las caracteristicas del servidor
```
cat /etc/*-release
```

- Instalar el manual
```
sudo apt install apache2-doc
```

- Se accede al manual con la siguiente direccion
```
(ip)/manual
```

- Directorio de configuracion de apache
```
/etc/apache2
```

- Permitir el puerto 22
```
sudo ufw allow 'OpenSSH'
```

- Instalar unzip
```
sudo apt install unzip
```

- Copiar de un directorio a otro los archivos
```
sudo cp -R . /var/www/alumnos
```

- Configuracion de la web de alumnos
```
sudo nano /etc/apache2/sites-available/alumnos.conf

<VirtualHost *:80>
    ServerName alumnos.com
    DocumentRoot /var/www/alumnos
</VirtualHost>
```

- Habilitar la web para poder verla
```
sudo a2ensite alumnos
systemctl reload apache2
```

- Deshabilitar la web para dejarla de ver
```
sudo a2dissite alumnos
systemctl reload apache2
```

- Archivo a modificar para el SSL en Ubuntu
```
/etc/apache2/sites-available/default-ssl.conf
```

- Modificacion SSL Ubuntu
```
SSLCertificateFile /etc/ssl/certs/certificado.crt
SSLCertificateKeyFile /etc/ssl/private/certificado.key
```

- VirtualHost para SSL
```
<VirtualHost *:80>
    ServerName alumnos.com
    DocumentRoot /var/www/alumnos
    Redirect permanent / https://alumnos.com
</VirtualHost>

<VirtualHost *:443>
    ServerName alumnos.com
    DocumentRoot /var/www/alumnos
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/certificado.crt
    SSLCertificateKeyFile /etc/ssl/private/certificado.key
</VirtualHost>
```

- Instalar php
```
sudo apt install php libapache2-mod-php php-mysql
```

- Instalar MariaDB / Mysql
```
sudo apt install mariadb-server
```

- Poner contraseña root a mysql
```
sudo mysql_secure_installation
```

- Instalar phpmyadmin
```
sudo apt install phpmyadmin
```
