# Descargar Ubuntu Server 18.04 LTS

- Ir al sitio web y descargarlo
- Crear en virtualbox un servidor de ubuntu y poner el archivo descargado
- Poner en español
- Darle todo a SI
- Ir a la red del servidor ubuntu y poner "Adaptador puente"

- Ver la ip:
```
ip addr show
```

- Conectarse desdel local:
```
sudo ssh rafael@192.168.1.154
```

- Le damos todo a 'yes'

## Configurar la IP estática


- Modificamos el archivo sudo nano 50-cloud-init.yaml:
```
sudo nano /etc/netplan/50-cloud-init.yaml
```

- Y ponemos:
```
network:
    ethernets:
        enp0s3:
#            dhcp4: true
             addresses: [192.168.1.154/24]
             gateway4: 192.168.1.2
             dhcp4: no
             nameservers:
                    addresses: [8.8.8.8,8.8.4.4]
             optional: true
    version: 2
```
- Reiniciamos la red:
```
sudo netplan apply
```

- Vamos a hosts y ponemos la ip de ubuntu-server con un nombre:
```
sudo nano /etc/hosts
192.168.1.179   ubuntu-server
```

- Ver estado del firewall:
```
sudo ufw status
```

- Estara inactivo. Para activarlo ponemos:
```
sudo ufw enable
```

- Podemos ver más información del firewall con:
```
sudo ufw status verbose
```

- Ver lista de aplicaciones permitidas por firewall:
```
sudo ufw app list
```

# Entrar en el servidor ubuntu a traves de tu servidor:
```
ssh nombre del servidor o ip
```

# Instalar Apache

- Instalarlo:
```
sudo apt install apache2
```

- Ver estado de apache:
```
systemctl status apache2
```

- Parar apache:
```
sudo apachectl stop
```

- Encender apache
```
sudo apachectl start
```

- Abrir puerto 80:
```
sudo ufw allow 'Apache'
```

- Abrir puerto 22:
```
sudo ufw allow 'OpenSSH'
```

- Ver características del servido apache:
```
cat /etc/*-release
```

## Instalar manual de apache:
```
sudo apt install apache2-doc
```

- Para ver el manual:
```
http://192.168.1.154/manual
```

# Simular distintas webs soportadas por el mismo servidor

- Descargamos web
- En FileZilla creamos servidor ubuntu
- Creamos la carpeta 'Descargas'
- Ponemos la web comprimida o descomprimida

- Si esta comprimida descargamos unzip:
```
sudo apt install unzip
```

- Lo descomprimimos:
```
unzip web comprimida
```

- cd en la web y creamos la carpeta que deseamos. Por ejemplo alumnos:
```
sudo mkdir /var/www/alumnos
```

- Copiar todos los archvos de web a alumnos:
```
sudo cp -R . /var/www/alumnos/
```

- Modifica index.html de alumnos:
```
sudo nano /var/www/alumnos/index.html
```

- Archivo de configuración de alumnos:
```
sudo nano /etc/apache2/sites-available/alumnos.conf
```

- Y ponemos:
```
<VirtualHost *:80>
   ServerName alumnos.com
   DocumentRoot /var/www/alumnos
</VirtualHost>
```
Aviso: uso alumno como ejemplo

- Para activar la configuración anterior ponemos:
```
sudo a2ensite alumnos
```

- Editamos hosts:
```
sudo nano /etc/hosts
```

- Y ponemos:
```
192.168.1.154   alumnos.com
```

- Reiniciamos apache:
```
sudo systemctl reload apache2
```

- Si queremos desabilitar el sitio web ponemos:
```
sudo a2dissite alumnos
```

# Modificar la configuración anterior para acceder a las dos páginas a través de dos direcciones IP distintas. Comprobar el funcionamiento correcto desde el navegador del cliente

- Ir a la red del servidor ubuntu y avilitar una nueva red.

- Modificamos el archivo sudo nano 50-cloud-init.yaml:
```
sudo nano /etc/netplan/50-cloud-init.yaml
```

- Ponemos los dominiso en dhcp4:true:
```
network:
    ethernets:
        enp0s3:
            dhcp4: true
#             addresses: [192.168.1.154/24]
#             gateway4: 192.168.1.2
#             dhcp4: no
#             nameservers:
#                    addresses: [8.8.8.8,8.8.4.4]
#             optional: true
        enp0s8:
            dhcp4: true
    version: 2
```

- Reiniciamos la red:
```
sudo netplan apply
```

- Asi podremos ver su ip en ubuntu server y ponerlo en buien en network:

- Volvemos a modificamos el archivo sudo nano 50-cloud-init.yaml:
```
sudo nano /etc/netplan/50-cloud-init.yaml
```

- Y ponemos:
```
network:
    ethernets:
        enp0s3:
#            dhcp4: true
             addresses: [192.168.1.154/24]
             gateway4: 192.168.1.2
             dhcp4: no
             nameservers:
                    addresses: [8.8.8.8,8.8.4.4]
             optional: true
enp0s8:
#            dhcp4: true
            addresses: [192.168.1.188/24]
            gateway4: 192.168.1.2
            dhcp4: no
            nameservers:
                   addresses: [8.8.8.8,8.8.4.4]
            optional: true
```

- Reiniciamos la red:
```
sudo netplan apply
```

- Vamos a hosts y ponemos la ip de ubuntu-server con un nombre:
```
sudo nano /etc/hosts
192.168.1.188   profesore.com
```

- Archivo de configuración de alumnos:
```
sudo nano /etc/apache2/sites-available/alumnos.conf
```

- Y ponemos:
```
<VirtualHost 192.168.1.179:80>
   ServerName alumnos.com
   DocumentRoot /var/www/alumnos
</VirtualHost>
```

- Archivo de configuración de profesores:
```
sudo nano /etc/apache2/sites-available/profesores.conf
```

- Y ponemos:
```
<VirtualHost 192.168.1.188:80>
   ServerName profesores.com
   DocumentRoot /var/www/profesores
</VirtualHost>
```

- Reiniciamos apache:
```
sudo systemctl reload apache2
```

# Modificar la configuración anterior para acceder a las dos páginas a través de dos puertos distintos (y una sola dirección IP). Comprobar el funcionamiento correcto desde el navegador del cliente.

- Si en VirtualBox tenemos dos redes debemos quitar una.

- Cambiamos la relación ip de la web cambiada por el mismo IP:
```
udo nano /etc/hosts
192.168.1.119   profesores.com
```

- Abrimos puertos 8001 y 8002:
```
sudo ufw allow 8001
sudo ufw allow 8002
```

- Reiniciamos firewall:
```
sudo ufw reload
```

- Modificamos archivo de configuración de profesores:
```
sudo nano /etc/apache2/sites-available/profesores.conf
```

- Y ponemos:
```
Listen 8002
<VirtualHost 192.168.1.179:8002>
   ServerName profesores.com
   DocumentRoot /var/www/profesores
</VirtualHost>
```

- Modificamos archivo de configuración de alumnos:
```
sudo nano /etc/apache2/sites-available/alumnos.conf
```

- Y ponemos:
```
Listen 8001
<VirtualHost 192.168.1.179:8001>
   ServerName alumnos.com
   DocumentRoot /var/www/alumnos
</VirtualHost>
```

- Reiniciamos Apache:
```
sudo systemctl reload apache2
```


# Añadir una página de administración en el dominio administracion.com, a la que solo se pueda acceder mediante user/pass (usar autenticación básica).

- Crear en la web de alumnos que solo pueda acceder el administrador

- Creamos carpeta para poner a los admin
```
sudo mkdir /var/www/alumnos/admin
```

- Creamos un html en admin:
```
sudo nano /var/www/alumnos/admin/index.html
```

- Creamo una carpeta donde guardamos los passwords:
```
sudo mkdir /etc/apache2/password
```

- Creamos el archivo para passwords:
```
sudo htpasswd -c /etc/apache2/password/passwords-admin ususario(un nombre)
```

- Ver admin:
```
cat /etc/apache2/password/passwords-admin
```

- Si queremos crear más passwords ponemos:
```
sudo htpasswd /etc/apache2/password/passwords-admin ususario(un nombre)
```

### Restringir el acceso:
```
sudo nano /etc/apache2/sites-available/alumnos.conf
```

- Ponemos
```
<Directory "/var/www/alumnos/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/apache2/password/passwords-admin
    Require valid-user
</Directory>
```

- Si quisieramos que solo uno pueda acceder ponemos:
```
<Directory "/var/www/clientes/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/httpd/password/passwords-admin
    Require user admin
</Directory>
```

- Reiniciamos apache:
```
sudo systemctl reload apache2
```

# Modifica la configuración de la aplicación web de profesores para que sólo se pueda acceder desde la dirección IP de tu cliente. Comprueba que esta configuración funciona tratando de acceder a esta página desde otro PC del aula.


- Creamos otra parte de la web
```
sudo mkdir /var/www/profesores/gestion
```

- Creamo una web dentro de gestion:
```
sudo nano /var/www/profesores/gestion/index.html
```

- Restringir acceso mediante ip:
```
sudo nano /etc/apache2/sites-available/profesores.conf

<Directory "/var/www/profesores/gestion">
    <RequireAll>
     Require all denied
    </RequireAll>
</Directory>
```

- Ver ipLocal:
```
Abrimos terminal en local y ponemos ip addr show
```

- Hacer que solo nos deje entrar con nuestra IP Local:
```
<Directory "/var/www/profesores/gestion">
    <RequireAll>
     # Require all denied
       Require ip ipLocal
    </RequireAll>
</Directory>
```

- Que todos puedan entrar excepto la ip que yo desee:
```
<Directory "/var/www/profesores/gestion">
    <RequireAll>
     # Require all denied
       Require all granted 
       Require not ip RandomIp
    </RequireAll>
</Directory>
```

- Un rango de IPs puedan acceder a la red:
```
<Directory "/var/www/profesores/gestion">
    <RequireAll>
       Require ip 192.168.1
       Require ip 192.168.1.0/255.255.255.0
       Require ip 192.168.1.0/24
    </RequireAll>
</Directory>
```

- Reniciamos siempre de cada variacion:
```
sudo systemctl reload apache2
```

# Crea una carpeta secret_files y un archivo secret_text.txt dentro de alumnos. Activa el indexado del directorio y comprueba que se puede acceder al archivo accediendo a alumnos.com/secret_files. Impide el acceso al contenido de esta carpeta a todos los usuarios utilizando htaccess. Comprueba que al intentar acceder ahora se muestra un mensaje de error (403).

- Creamos carpeta para htaccess
```
sudo mkdir /var/www/alumnos/secret_files
```

- Datos.txt
```
sudo nano /var/www/alumnos/secret_files/secret_text.txt
```

- Añadimos
```
sudo nano /etc/apache2/sites-available/alumnos.conf

<Directory "/var/www/alumnos/secret_files">
    AllowOverride All
    Options Indexes
</Directory>
```
- Reniciamos apache:
```
sudo systemctl reload apache2
```

- Creamos un archivo htaccess, en el cual podremos configurar secret_files de forma inmediata sin necesidad de reiniciar apache:
```
sudo nano /var/www/alumnos/secret_files/.htaccess
```

- Añadimos:
```
Require all denied
```
Y reiniciamos apache
```
sudo systemctl reload apache2
```

# Configura la página alumnos.com para que sólo se pueda acceder a ella mediante una conexión segura (https). En ubuntu no es necesario instalar el módulo ssl, ya está instalado con la instalación por defecto de apache, pero hay que activarlo (sudo a2enmod ssl). Tampoco es necesario instalar openssl (si no estuviera instalado: sudo apt install openssl)


## Configuración de SSL (Secure Sockets Layer) en apache

- Si queremos que nuestra web tenga conexión segura debemos usar SSL

### Crear clave privada

```
openssl genrsa -out certificado.key 2048
```

### Crear archivo csr

```
openssl req -new -key certificado.key -out certificado.csr
Poner todos los datos vacios excepto el password
```
### Crear archivo crt

```
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```

### Agregar el certificado al servidor

- Copiar los archivos:
```
sudo cp certificado.crt /etc/ssl/certs 
sudo cp certificado.key /etc/ssl/private
```

- Configurar el archivo ssl para que detecte los certificados:
```
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

- Cambiamos las lineas:
```
SSLCertificateFile /etc/ssl/certs/certificado.crt
SSLCertificateKeyFile /etc/ssl/private/certificado.key
```

- Reiniciamos apache:
```
sudo systemctl reload apache2
```

- Abrimos ufw:
```
sudo ufw enable
```

- Instalamos Apache Full:
```
sudo ufw allow 'Apache Full'
```

- Ver si esta:
```
sudo ufw status
```

- Accedemos  por https:
```
sudo nano /etc/apache2/sites-available/alumnos.conf

<VirtualHost *:80>
        DocumentRoot /var/www/alumnos
        ServerName alumnos.com
       	Redirect / https://alumnos.com
</VirtualHost>

<VirtualHost *:443>
    DocumentRoot /var/www/alumnos
    ServerName alumnos.com
    SSLEngine On
    SSLCertificateFile /etc/ssl/certs/certificado.crt
    SSLCertificateKeyFile /etc/ssl/private/certificado.key
</VirtualHost>

```

- Y reiniciamos apache
```
sudo systemctl reload apache2
```

# Instalar PHP en ubuntu server

```
sudo apt install php libapache2-mod-php php-mysql
```

## Añadir pagina php 

```
sudo nano /var/www/alumnos/index.php(si en vez de poner 'alumnos' ponemos 'html' podremos acceder a traves de nuestra ip)
<?php phpinfo(); ?>
```

- Reiniciamos apache:
```
sudo systemctl reload apache2
```

# Intalar MariaDB

```
sudo apt install mariadb-server
```

- Instalar seguridad mariadb:
```
sudo mysql_secure_installation
poner password y decir todo a SI
```

- Comprobar bbddd existentes:
```
sudo mysql -u root -p
```

- ver la BBDD:
```
show DATABASES;
```

- Crear base de datos:
```
CREATE DATABASE examen_db;
```

- Parar:
```
quit;
```

# Instalar PHPMyAdmin

```
sudo apt install phpmyadmin

Dar a apache2
```

- Ver apache.conf:
```
sudo nano /etc/phpmyadmin/apache.conf
```

- Crear el enlace:
```
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo ln -s /etc/apache2/conf-available/phpmyadmin.conf /etc/apache2/conf-enabled/phpmyadmin.conf
```

- Reiniciamos apache:
```
sudo systemctl reload apache2
```