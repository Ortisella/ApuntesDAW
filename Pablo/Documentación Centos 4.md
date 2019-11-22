# Documentación Centos 4

# PhP y msql
-Crear archivo php en www/clientes
```
sudo nano /var/www/clientes/index.php
```

-Poner esto en el archivo:
```
<?php phpinfo(); ?>
```

-Reiniciar servidor y buscar en navegador el ip/index.php
```
sudo apachectl restart
http://192.168.1.182/index.php
```
- Instalar paquetes de mysql(Si no funciona hacer un sudo reboot, y/o cambiar el archivo a como estaba antes con Dhcp):
```
sudo yum install mariadb mariadb-server
```
-Comprobar mariadb
```
sudo systemctl status mariadb
```
-Iniciar mariadb:
```
sudo systemctl start mariadb
```

-Para que al iniciar el servidor arranque mariadb:
```
sudo systemctl enable mariadb
sudo systemctl status mariadb
```
-Configurar seguirdad de la base de datos:
```
sudo mysql_secure_installation
```
-Darle a intro cuando pida la password root y poner no en set password , luego yes a todo

-Probar que funciona:
```
mysql -u root -p
```
-Mostrar las bases de datos:
```
show DATABASES;
```
-Crear database:
```
create DATABASE hola;
```
-Salir de mysql:
```
quit
```
# Instalar phpmyadmin
-Instalar dependencias (Si falla comprobar internet, en clase debe ser GATEWAY 1.2)
```
sudo yum install php-pecl-zip php-mbstring
```
-Instalar phpmyadmin
```
sudo yum install phpmyadmin
```
-Modificar fichero de configuración de phpmyadmin:
```
ll /etc/httpd/conf.d/
sudo nano /etc/httpd/conf.d/phpMyAdmin.conf
```
-Hacer esto en el archivo:
```
<IfModule mod_authz_core.c>
     # Apache 2.4
#     <RequireAny>
#      Require ip 127.0.0.1
#      Require ip ::1
#     </RequireAny>
    Require all granted
   </IfModule>

```
-Reiniciar servidor apache:
-Probar http://centos-server/phpmyadmin/

# Seguridad Apache
## Autenticación básica (acceder ciertas personas)
-Crear en web clientes una página que solo pueda acceder un administrador:
```
sudo mkdir /var/www/clientes/admin
```
-Ponerle un index.html y rellenarla (Página restringida a administradores):
```
sudo nano /var/www/clientes/admin/index.html
```
-Buscar en navegador, antes reiniciar ip/admin

-Crear carpeta password
```
sudo mkdir /etc/httpd/password
```
-Crear un usuario para passwords-admin(-c es para crear la carpeta si no existe):
```
sudo htpasswd -c /etc/httpd/password/passwords-admin admin
sudo htpasswd /etc/httpd/password/passwords-admin admin2 //Para crear mas usuarios
```
-poner admin como password

-Visualizar passwords-admin
```
cat /etc/httpd/password/passwords-admin
```
-Cambiar configuración carpeta clientes
```
sudo nano /etc/httpd/conf.d/clientes.conf
```

-Poner esto en clientes.conf
```
<VirtualHost *:80>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
</VirtualHost>

<Directory "/var/www/clientes/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/httpd/password/passwords-admin
    Require valid-user
    # Require user admin
</Directory>
```
-Comprobar que en la configuracion no hay error y reiniciar servidor:
```
sudo apachectl configtest
sudo apachectl restart
```

-Comprobar en el navegador que te solicita usuario admin y contraseña:
```
http://192.168.1.182/admin/
```
## Autenticación Digest
-Crear carpeta admin dentro de proveedores
```
sudo mkdir /var/www/proveedores/admin
```
-Crear un index.html dentro con contenido:
```
sudo nano /var/www/proveedores/admin/index.html
```
-Crear un grupo digest "administradores" y un usuario dentro de ese grupo:
```
sudo htdigest -c /etc/httpd/password/digest "administradores" admin
```
-Visualizar en Digest los usuarios:
```
cat /etc/httpd/password/digest
```
-Crea otro usuario en ese grupo:
```
sudo htdigest /etc/httpd/password/digest "administradores" admin2
```
-Visualizar en Digest los usuarios:
```
cat /etc/httpd/password/digest
```
-Modificar archivo configuracion de proveedores:
```
sudo nano /etc/httpd/conf.d/proveedores.conf

<VirtualHost *:80>
    DocumentRoot /var/www/proveedores
    ServerName proveedores.com
</VirtualHost>

<Directory "/var/www/proveedores/admin">
    AuthType Digest
    AuthName "administradores" # Debe coincidir con el grupo
    AuthUserFile /etc/httpd/password/digest         
    # Require valid-user //Entra solo los validados en "administradores"
    Require user admin //Entra solo el validado en "administradores"   llamado admin
</Directory>

```
-Comprobar que en la configuracion no hay error y reiniciar servidor:
```
sudo apachectl configtest
sudo apachectl restart
```
-Comprobar en navegador proveedores.com/admin
```
http://proveedores.com/admin/
```

## Control de acceso
-Crear carpeta gestion en clientes:
```
sudo mkdir /var/www/clientes/gestion
```
-Crear un index.html dentro de gestion(web restringida al departamento de gestion):
```
sudo nano /var/www/clientes/gestion/index.html
```
-Modificar clientes.conf (Denegar a todos)
```
sudo nano /etc/httpd/conf.d/clientes.conf

<Directory "/var/www/clientes/gestion">
    <RequireAll>
       Require all denied
    </RequireAll>
</Directory>

```
-Reiniciar y comprobar en navegador

-Configurar otra vez archivo clientes.conf (No denegar a todos):
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
      # Require all denied
      # Require all granted
      
      # Require ip 192.168.1.124  #Ip local del ordenador, solo puede accder mi ordenador
      # Require ip 192.168.1.0/255.255.255.0 #Es para que entren las ips que cumplan esa condición
      Require ip 192.168.1.0/24
      
      # Require not ip 192.168.1.124 
    </RequireAll>
</Directory>

```
-Reiniciar y buscar en el navegador

## Control de acceso a nivel de carpeta (.htaccess Ventaja: no hace falta reiniciar sevidor)
-Crear carpeta nueva en clientes:
```
sudo mkdir /var/www/clientes/testhtaccess
```
-Crear un index.html dentro de testhtaccess():No Crear!!! STOP!!!
```
sudo nano /var/www/clientes/testhtaccess/index.html
```
-Modificar clientes.conf(añadir nuevo directorio):
```
<Directory "var/www/clientes/testhtaccess">
    AllowOverride All
    Options Indexes #Muestra un indice de los archivos del directorio
</Directory>

```
-No tener un archivo llamado index porque no funcionaria, asi que borrar index si se creó y crear un datos.txt:
```
sudo rm /var/www/clientes/testhtaccess/index.html
sudo nano /var/www/clientes/testhtaccess/datos.txt
```
-Buscar en navegador el testhtaccess/datos.txt

-Poner dentro Require all denied (Deniega el acceso a toda la carpeta testhtaccess) 
```
sudo nano /var/www/clientes/testhtaccess/.htaccess
Require all denied
```

## Configuración de SSL (Secure Sockets Layer) en apache
-En el servidor :
```
sudo yum install openssl
```

### Crear una clave privada
-Generar clave
```
openssl genrsa -out certificado.key 2048
```
### Crear archivo csr
-Generar:
```
openssl req -new -key certificado.key -out certificado.csr

```
-Visualizar:
```
ll
```

### Crear archivo crt
```
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt

```
## Más cosas de seguridad
-Instalar modulo de apache para conexiones seguras:
```
sudo yum install mod_ssl
```

-Copiar certificados donde deben estar:
```
sudo cp certificado.crt /etc/pki/tls/certs
sudo cp certificado.key /etc/pki/tls/private
```

-Editar y reiniciar cambiar las lineas sslCertificateFile y sslcertificatekeyfile:
```
sudo nano /etc/httpd/conf.d/ssl.conf
#   Server Certificate:
# Point SSLCertificateFile at a PEM encoded certificate.  If
# the certificate is encrypted, then you will be prompted for a
# pass phrase.  Note that a kill -HUP will prompt again.  A new
# certificate can be generated using the genkey(1) command.
SSLCertificateFile /etc/pki/tls/certs/certificado.crt

#   Server Private Key:
#   If the key is not combined with the certificate, use this
#   directive to point at the key file.  Keep in mind that if
#   you've both a RSA and a DSA private key you can configure
#   both in parallel (to also allow the use of DSA ciphers, etc.)
SSLCertificateKeyFile /etc/pki/tls/private/certificado.key

```
-Modificar virtualHost de clientes:
```
sudo nano /etc/httpd/conf.d/clientes.conf
<VirtualHost *:80>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
    Redirect permanent / https://clientes.com
</VirtualHost>

<VirtualHost *:443>
    ServerName clientes.com
    DocumentRoot /var/www/clientes
    SSLEngine on
    SSLCertificateFile /etc/pki/tls/certs/certificado.crt
    SSLCertificateKeyFile /etc/pki/tls/private/certificado.key
</VirtualHost>

```
-Reiniciar

-Abrir puerto y buscar en navegador https://clientes.com:
```
sudo firewall-cmd --zone=public --add-service=https --permanent
sudo firewall-cmd --reload
```
-Reiniciar y  buscar https://clientes.com
