## Modificar la configuración anteriro para acceder a las dos páginas a través de dos direcciones IP distintas (Solo acceder por IP). Comprobar el funcionamiento correcto desde el navegadro del cliente
- Añadir otro adaptador puente en configuraciones
- Crear un nuevo enp0s8:
```
sudo nano /etc/netplan/50-cloud-init.yaml
```
- Crear una nueva ip statica para que al entrar nos de dos ips
- Se puede poner ip statica a las nuevas ips que nos han dado
```
network:
    ethernets:
        enp0s3:
#            dhcp4: true
             addresses: [192.168.1.175/24] // Ip uno
             gateway4: 192.168.1.2
             dhcp4: no
             nameservers: 
                 addresses: [8.8.8.8,8.8.4.4]
             optional: true
        enp0s8:
#            dhcp4: true
             addresses: [192.168.1.187/24]
             gateway4: 192.168.1.2
             dhcp4: no
             nameservers:
                 addresses: [8.8.8.8,8.8.4.4]
             optional: true

    version: 2
```
```
sudo netplan apply
```
- Acceder al servidor y comprobar ips que son las staticas:
```
ip addr show
```
- Retocar el archivo de configuracion alumnos y profesores, y poner ip distinta para cada uno:
```
sudo nano /etc/apache2/sites-available/alumnos.conf
sudo nano /etc/apache2/sites-available/profesores.conf
```
- Cambiar configuración (Quitar servername porque no se llama por dominio):
```
<VirtualHost 192.168.1.175:80> //Ip 1
    DocumentRoot /var/www/alumnos
</VirtualHost>


<VirtualHost 192.168.1.187:80> //Ip 2
    DocumentRoot /var/www/profesores
</VirtualHost>
```
- Reiniciar y aplicar:
```
sudo systemctl restart apache2
sudo netplan apply
``` 
- Cambiar archivo de hosts, comentar los dominios para que entre solo por ip no por nombre:
```
192.168.1.175   ubuntu-server
#192.168.1.175   alumnos.com
#192.168.1.175   profesores.com
```

## Modifica la configuración anterior para acceder a las dos páginas a través de dos puertos distintos (8001 y 8002) en una misma dirección IP. Comprobar el funcionamiento correcto desde el navegador del cliente.
- Si se desea volver a tener solo una ip en el servidor hacer lo de abajo
- Modificar archivo .yaml para que solo haya una ip statica:
```
sudo nano /etc/netplan/50-cloud-init.yaml
network:
    ethernets:
        enp0s3:
#            dhcp4: true
             addresses: [192.168.1.175/24]
             gateway4: 192.168.1.2
             dhcp4: no
             nameservers:
                 addresses: [8.8.8.8,8.8.4.4]
             optional: true

    version: 2

```

- Modificar archivos alumnos.conf y profesores.conf para que accedan por puerto distinto:
```
sudo nano /etc/apache2/sites-available/alumnos.conf
sudo nano /etc/apache2/sites-available/profesores.conf
```

- Poner puerto para cada uno:
```
Listen 8001
<VirtualHost *:8001>
    DocumentRoot /var/www/alumnos
</VirtualHost>

Listen 8002
<VirtualHost *:8002>
    DocumentRoot /var/www/profesores
</VirtualHost>

```
- Abrir puertos en firewall en ubuntu, no confundir con centos:
```
sudo ufw allow '8001'
sudo ufw allow '8002'
```

- Reiniciar y aplicar:
```
sudo systemctl restart apache2
sudo netplan apply
```
- Acceder por servidor:puerto

## Añadir una página de administración en el dominio administracion.com, a la que solo se pueda acceder mediante user/pass (usar autenticación básica, user: admin, pass:admin)
- Crear una carpeta administración con un index.html:
```
sudo mkdir /var/www/administración
sudo nano /var/www/administración/index.html
```
- Crear una carpeta password con password-admin donde crearemos un usuario admin (apache2 en ubuntu)
```
sudo mkdir /etc/apache2/password
sudo htpasswd -c /etc/apache2/password/passwords-admin admin
```
- Visualizar passwords-admin
```
cat /etc/apache2/password/passwords-admin
```
- Modificar fichero conf de administración con autentificación básica:
```
sudo nano /etc/apache2/sites-available/administración.conf
<VirtualHost *:80>
    DocumentRoot /var/www/administración
    ServerName administracion.com
</VirtualHost>

<Directory "/var/www/administración/">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/apache2/password/passwords-admin
    Require valid-user
    # Require user admin
</Directory>

```
- Comprobar que administración no esta activada y activarla (En Centos esto no se hace)
```
ll /etc/apache2/sites-enabled/
sudo a2ensite administración
systemctl reload apache2
```
- En el ordenador local en hosts añadir administracion.com:
```
127.0.0.1       localhost
127.0.1.1       MateAulas
192.168.1.182   miservidor
192.168.1.182   clientes.com
192.168.1.182   proveedores.com

192.168.1.175   ubuntu-server
192.168.1.175   administracion.com
```

- Reiniciar y aplicar:
```
sudo systemctl restart apache2
sudo netplan apply
```

## Modifica la configuración de la aplicación web de profesores para que sólo se pueda acceder desde la dirección IP de tu cliente. Comprueba que esta configuración funciona tratando de acceder a esta página desde otro PC del aula.

- Configurar archivo de profesores:
```
sudo nano /etc/apache2/sites-available/profesores.conf
<Directory "/var/www/profesores">
    <RequireAll>
      # Require all denied
      # Require all granted //Permite a todos
      
        Require ip 192.168.1.124  #Ip local del ordenador, solo puede accder mi ordenador
      # Require ip 192.168.1.0/255.255.255.0 #Es para que entren las ips que cumplan esa condición 
      # Require ip 192.168.1.0/24
      
      # Require not ip 192.168.1.124 
    </RequireAll>
</Directory>
```
- Reiniciar y aplicar:
```
sudo systemctl restart apache2
sudo netplan apply
```
## Crea una carpeta secret_files y un archivo secret_text.txt dentro de alumnos. Activa el indexado del directorio y comprueba que se puede acceder al archivo accediendo a alumnos.com/secret_files. Impide el acceso al contenido de esta carpeta a todos los usuarios utilizando htaccess. Comprueba que al intentar acceder ahora se muestra un mensaje de error (403).

- Crear una carpeta secret_files dentro de alumnos
```
sudo mkdir /var/www/alumnos/secret_files
```
- Y un archivo txt dentro de la carpeta (escribir algo en el archivo)
```
sudo nano /var/www/alumnos/secret_files/secret_text.txt
```
- (OPCIONAL) Poner que se pueda acceder a alumnos.com por dominio alumnos.com
```
sudo nano /etc/apache2/sites-available/alumnos.conf
<VirtualHost *:80>
    ServerName alumnos.com
    DocumentRoot /var/www/alumnos
</VirtualHost>

```
- Reiniciar y aplicar cambios
```
sudo systemctl restart apache2
sudo netplan apply
```
- Cambiar en hosts y descomentar o poner alumnos.com y la ip del servidor
```
ip del servidor     alumnos.com
```
- Probar en el navegador alumnos.com/secret_files

- Modificar alumnos.conf:
```
sudo nano /etc/apache2/sites-available/alumnos.conf
<Directory "var/www/alumnos/secret_files">
    AllowOverride All   #Poner si o si
    Options Indexes  #Te deja ver lo que hay dentro pero no te deja acceder a los contenidos 
</Directory>

```
- Reiniciar
```
sudo systemctl restart apache2
sudo netplan apply
```

- Poner esto para usar control de acceso con htacces y poner dentro de .htacces Require all denied
```
sudo nano /var/www/alumnos/secret_files/.htaccess
Require all denied
```

- No hace falta reiniciar al modificar .htacces

## Configura la página alumnos.com para que sólo se pueda acceder a ella mediante una conexión segura (https). En ubuntu no es necesario instalar el módulo ssl, ya está instalado con la instalación por defecto de apache, pero hay que activarlo (sudo a2enmod ssl). Tampoco es necesario instalar openssl (si no estuviera instalado: sudo apt install openssl)

- Activar módulo ssl:
```
sudo a2enmod ssl
```
- Reiniciar
```
systemctl restart apache2
```

### Crear una clave privada
- Generar clave
```
openssl genrsa -out certificado.key 2048
```
### Crear archivo csr
- Generar y dar intro a todo:
```
openssl req -new -key certificado.key -out certificado.csr

```
- Visualizar:
```
ll
```
### Crear certificado 
```
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```

### Agregar certificados al servidor apache
- Copiar certificados donde deben estar:
```
sudo cp certificado.crt /etc/ssl/certs
sudo cp certificado.key /etc/ssl/private
```
- Configurar el archivo ssl para detectar los certificados:
```
sudo nano /etc/apache2/sites-available/default-ssl.conf
```
- Modificar el archivo y cambiar las lineas sslCertificateFile y sslcertificatekeyfile:
```
SSLCertificateFile /etc/ssl/certs/certificado.crt      
SSLCertificateKeyFile /etc/ssl/private/certificado.key 
```
- Reiniciar:
```
sudo netplan apply
sudo systemctl reload apache2
```
- Configurar firewall:
```
sudo ufw enable
sudo ufw allow 'Apache full'
```

- Modificar alumnos, //Podria entrar por puerto tambien o solo por ip
```
sudo nano /etc/apache2/sites-available/alumnos.conf
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

- Reiniciar:
```
sudo netplan apply
sudo systemctl reload apache2
```
- Buscar https://alumnos.com

## Instalar php

- Instalar
```
sudo apt install php libapache2-mod-php php-mysql
```
- Crear archivo php en www/alumnos
```
sudo nano /var/www/alumnos/index.php
```
- Poner esto en el archivo:
```
<?php phpinfo(); ?>
```
- Reiniciar:
```
sudo netplan apply
sudo systemctl reload apache2
```
- Instalar mariaDB: 
```
sudo apt install mariadb-server
```
- Seguridad mariadb:
``` 
sudo mysql_secure_installation
```
- Iniciar mariadb
```
sudo mysql -u root -p
```
- Ver las bases de datos y crear
```
show DATABASES;
create DATABASE hola;
```
- Para salir de mariadb
```
quit
```
- Instalar phpmyadmin darle a No al final
```
sudo apt install phpmyadmin
ll /etc/phpmyadmin/
```
- Poner esto para que nos deje entrar en el navegador ip-server/phpmyadmin/:
```
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo ln -s /etc/apache2/conf-available/phpmyadmin.conf /etc/apache2/conf-enabled/phpmyadmin.conf
```
## Crear un grupo digest en ubuntu
- Habilitar modulo digest en ubuntu-server:
```
sudo a2enmod auth_digest
systemctl restart apache2
```
- Crear carpeta gestion en alumnos con un index.html:
```
sudo mkdir /var/www/alumnos/gestion
sudo nano /var/www/alumnos/gestion/index.html
```
- Crear un usuarios admin y admin2 en el grupo digest
```
sudo htdigest -c /etc/apache2/password/digest "gestiones" admin
sudo htdigest /etc/apache2/password/digest "gestiones" admin2
```
- Visualizar grupo digest
```
cat /etc/apache2/password/digest
```

- Modificar y añadir en alumnos.conf:
```
sudo nano /etc/apache2/sites-available/alumnos.conf

<Directory "/var/www/alumnos/gestion">
    AuthType Digest
    AuthName "gestiones" # Debe coincidir con el grupo
    AuthUserFile /etc/apache2/password/digest         
    # Require valid-user //Entra solo los validados en "gestiones"
    Require user admin //Entra solo el validado en "gestiones"   llamado admin
</Directory>
``` 
- Reiniciar:
```
sudo netplan apply
sudo systemctl reload apache2
```