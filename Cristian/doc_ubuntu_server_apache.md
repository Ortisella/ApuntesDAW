- [CONEXIÓN POR SSH A LA MÁQUINA VIRTUAL](#Conexión-por-SSH-a-la-máquina-virtual)
    - [Adaptador puente](#Adaptador-puente)
    - [Configurar la IP estática](#Configurar-la-IP-estática)
    - [Configuración del host del servidor](#Configuración-del-host-del-servidor)
    - [Confgurar el Firewall](#Configurar-el-Firewall)

- [INSTALACIÓN DE APACHE EN UBUNTU-SERVER](#Instalación-de-Apache-en-Ubuntu-Server)
      
- [TRATAMIENTO DEL CONTENIDO DEL SERVIDOR CON FILEZILLA](#Añadir-el-servidor-a-FileZilla)

- [SIMULAR DISTINTAS WEBS SOPORTADAS POR EL MISMO SERVIDOR](#Simular-distintas-webs-soportadas-por-el-mismo-servidor)
    - [Configurar las carpetas y archivos de las webs](#Configurar-las-carpetas-y-archivos-de-las-webs)
    - [Asignar la misma IP para cada web](#Asignar-la-misma-IP-para-cada-web)
    - [Asignar 1 IP distinta para cada web (En caso de disponer de 2 IPS)](#Asignar-1-IP-distinta-para-cada-web-(En-caso-de-disponer-de-2-IPS))
    - [Crear una página nueva con un puerto distinto en la misma IP](#Crear-una-página-nueva-con-un-puerto-distinto-en-la-misma-IP)
    - [Ensites y Dissites](#Cuando-cambiamos-el-archivo-conf-de-un-sitio-que-ya-estaba-configurado-con-un-virtualhost-distinto-al-actual-hay-que-hacer-ensites-y-dissites-en-apache)
    
- [CONFIGURAR LA SEGURIDAD DE APACHE](#Configurar-la-seguridad-de-apache)
    - [Autenticación básica](#Autenticación-básica)
    - [Control de Acceso](#Control-de-Acceso)
    - [Control de acceso a nivel de carpeta (.htaccess)](#Control-de-acceso-a-nivel-de-carpeta-(.htaccess))
    - [Configuración de SSL (Secure Sockets Layer) en apache](#Configuración-de-SSL-(Secure-Sockets-Layer)-en-apache)

- [INSTALACIÓN DE PHP Y SUS CONFIGURACIONES](#Instalación-de-PHP-y-sus-configuraciones)
    - [Añadir una página de PHP con BBDD](#Añadir-una-página-de-PHP-con-BBDD)
    - [Instalación de phpmyadmin](#Instalación-de-phpmyadmin)


# Conexión por SSH a la máquina virtual

- Cargar la iso en el Virtual Box
- Todo a sí
- Marcar el OpenSSH para instalarlo junto al SO

## Adaptador puente
- Ir a la configuración red de VirtualBox y marcar adaptador puente.

- Entonces el servidor ya nos genera una IP válida en 192.168.1

- De esta manera ya nos podemos conectar al servidor desde local con ssh

```
sudo ssh cristian@192.168.1.141 (ip generada)
```

## Configurar la IP estática

```
sudo nano /etc/netplan/50-cloud-init.yaml  
```

- Ponemos:
```
network:
    ethernets:
        enp0s3:
        #   dhcp4: true
            addresses: [192.168.1.141/24] (ip generada)
            gateway4: 192.168.1.1 (en clase el 2)
            nameservers:
                addresses: [8.8.8.8, 8.8.4.4]
            optional: true
    version: 2

```

- Reiniciamos la red
```
sudo netplan apply
```

## Configuración del host del servidor

- Abrimos el archivo de hosts en local
```
sudo nano /etc/hosts

192.168.1.124 ubuntu-server
```

- Ahora ya podemos conectarnos al servidor de esta manera:
```
sudo ssh cristian@ubuntu-server
```

## Configurar el Firewall

- Activamos el firewall:
```
sudo ufw enable
```

- Consultar el estado detallado del firewall
```
sudo ufw status verbose
```

- Consultar la lista de aplicaciones permitidas en el firewall
```
sudo ufw app list
```
-----

# Instalación de Apache en Ubuntu Server
```
sudo apt install apache2
```

- Instrucciones
```
sudo apachectl start
sudo apachectl stop
sudo apachectl restart
systemctl status apache2
```

## Abrir el puerto en Firewall
```
sudo ufw allow 'Apache'
```
----

- Caracteristicas del servidor apache
```
cat /etc/*-release
```


- Instalar el manual de Apache:
```
sudo apt install apache2-doc
```

- Podremos acceder mediante:
```
192.168.1.124/manual

o

ubuntu-server/manual
```

# Simular distintas webs soportadas por el mismo servidor

## Añadir el servidor a FileZilla

- Permitimos el SSH en el Firewall abriendo el puerto 22
```
sudo ufw allow 'OpenSSH'
```

- Creamos un nuevo sitio con el servidor de ubuntu en Filezila con: SFTP y modo Normal, nuestra IP, usuario y contraseña

- Creamos la carpeta Descargas en nuestra carpeta desde FileZilla para tener el acceso y poner ahi archivos

- Descarmganmos el unzip
```
sudo apt install unzip
```

- Descomprimimos:
```
cd Descargas
sudo unzip web_daw.zip
```
-----

## Configurar las carpetas y archivos de las webs
- Creamos carpeta:

```
sudo mkdir /var/www/alumnos
```

- Copiar el contenido de la web en la carpeta:
- Nos ponemos en la carpeta de web_daw y ponemos:

```
cd web_daw
sudo cp -R . /var/www/alumnos
```

- Editamos el index.html de alumnos para identificar la pagina

```
sudo nano /var/www/alumnos/index.html
```


## Asignar la misma IP para cada web
- Creamos el archivo de configuracion
```
sudo nano /etc/apache2/sites-available/alumnos.conf
```
```
<VirtualHost *:80>                            
    DocumentRoot /var/www/alumnos
    ServerName alumnos.com
</VirtualHost>
```

- Hacemos un enlace de sites-available a sites-enabled:
```
sudo a2ensite alumnos
```

- Para desabilitarlo:
```
sudo a2dissite alumnos
```

- Reiniciamos apache:
```
sudo systemctl reload apache2
```

- Creamos un host en local:
```
sudo nano /etc/hosts

192.168.1.124 alumnos.com
```
 
 - Si no se muestra limpiamos la cache del navegador


- Hacemos lo mismo para una web de profesores

## Asignar 1 IP distinta para cada web (En caso de disponer de 2 IPS)

- Cerramos la maquina virtual
- Añadimos otro adaptador puente en el virtualBox desde la configuracion web

- Volvemos a iniciar la máquina virtual

- Configuramos para que los dos adaptadores generen la IP por dhcp:

```
sudo nano /etc/netplan/50-cloud-init.yaml
```

```
network:
    ethernets:
        enp0s3:
            dhcp4: true
        enp0s8:
            dhcp4: true
    version: 2
```


- Vemos que IPS nos ha generado
```
ip addr show
```

- Despues de comprobar las IPS podemos configurar el mimso archivo para dejarlas como estaticas
(Arriba sale como hacerlas estáticas)

- Cambiamos el archivo VirtualHost para poner un ip distinta a cada una
```
sudo nano /etc/apache2/sites-available/alumnos.conf
sudo nano /etc/apache2/sites-available/profesores.conf
```

```
<VirtualHost 192.168.1.180:80>
    DocumentRoot /var/www/alumnos
    ServerName alumnos.com
</VirtualHost>


<VirtualHost 192.168.1.195:80>
    DocumentRoot /var/www/profesores
    ServerName profesores.com
</VirtualHost>
```

- Despues reubicar los sites:
```
sudo a2disssite alumnos
sudo systemctl reload apache2
sudo a2disssite profesores
sudo systemctl reload apache2
```
```
sudo a2ensite alumnos
sudo systemctl reload apache2
sudo a2ensite profesores
sudo systemctl reload apache2
```
- Despues limpiar la cache del navegador con CTR+F5

- Ahora estan asignadas la ips en cada página y debemos cambiar el archivo hosts de local ya que lo teniamos configurado para que apuntaran a la misma

```
exit
sudo nano /etc/hosts
```

-----
## Crear una página nueva con un puerto distinto en la misma IP

- Configuramos el archivo de configuración para que funcionen por distintos puertos
```
sudo nano /etc/apache2/sites-available/alumnos.conf
sudo nano /etc/apache2/sites-available/profesores.conf
```

- Declaramos que escuche por otro puerto distinto que el de los otros
```
Listen 8001
<VirtualHost *:8001> ( o la * para la primera, o especificar la que quieres )
    DocumentRoot /var/www/alumnos
    ServerName alumnos.com
</VirtualHost>
```

```
Listen 8002
<VirtualHost *:8002>
    DocumentRoot /var/www/profesores
    ServerName profesores.com
</VirtualHost>
```

- Reiniciamos el servidor
```
sudo systemctl reload apache2
```

(Tambien se puede hacer lo de los ensites y dissites si no va)

- Abrimos esos puerto en el Firewall
```
sudo ufw allow 8001
sudo ufw allow 8002
```

- Y recargamos el Firewall
```
sudo ufw reload
```

- Ahora podemos acceder a esa pagina especificando el puerto:
```
192.168.1.180:8001
192.168.1.180:8002
```

- Si añadimos esta nueva IP con puerto a hosts podremos generar un acceso.
---

## Cuando cambiamos el archivo conf de un sitio que ya estaba configurado con un virtualhost distinto al actual hay que hacer ensites y dissites en apache

- Ejemplo

```
sudo a2disssite alumnos
sudo systemctl reload apache2
sudo a2disssite profesores
sudo systemctl reload apache2
```
```
sudo a2ensite alumnos
sudo systemctl reload apache2
sudo a2ensite profesores
sudo systemctl reload apache2
```

----

# Configurar la seguridad de apache

## Autenticación básica

- Imaginamos que tenemos páginas que solo pueden ver personas autorizadas

- Creamos otra página en la web de alumnos en la que solo pueda acceder el administrador 

```
sudo mkdir /var/www/alumnos/admin

sudo nano /var/www/clientes/admin/index.html
```
- Y ponemos algo dentro para identificarla

- Creamos una carpeta donde crear los usuarios y sus passwords en un archivo
```
sudo mkdir /etc/apache2/password

sudo htpasswd -c /etc/apache2/password/passwords-admin admin
```
- Segun la instrucción anterior añadirmos el usuario admin al archivo de contraseñas passwords-admin

- Si añadimos otro usuario al archivo tendremos que quitar el -c de la instrucción anterior ya que el archivo ya estaría creado

```
sudo htpasswd /etc/apache2/password/passwords-admin admin2
```

- Ponemos de contraseña "admin"

- Así podemos ver la contraseñas de los usuarios en el archivo de forma encriptada
```
cat /etc/apache2/password/passwords-admin
```

- Restringimos el acceso de la página

```
sudo nano /etc/apache2/sites-available/alumnos.conf
```

- Ponemos:
```
<Directory "/var/www/clientes/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/httpd/password/passwords-admin
    Require valid-user 
</Directory>
```

- Con el Require decimos que sea validado cualquier usuario registrado en la ruta, si solo queremos que sea un usuario especifico ponemos: Require user admin

- Comprobar que en la configuración no hay un error sintáctico
```
sudo apachectl configtest
```

- Reiniciar apache: 
```
sudo systemctl reload apache2
```

- Ahora si entramos al navegador nos pedira usuario y contraseña
```
(ipdealumnos(con puerto si hay))/admin/

o 

clientes.com(con puerto si hay)/admin
```

## Control de Acceso

- Podemos restringir el acceso por IPs o rangos de IPs

- Vamos a crear otro archivo en alumnos

```
sudo mkdir /var/www/profesores/gestion

sudo nano /var/www/profesores/gestion/index.html
```

- Ponemos dentro un mensaje acorde

- Modificamos el archivo de configuración
```
sudo nano /etc/apache2/sites-available/profesores.conf
```

- Añadimos 
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
        Require all denied
    </RequireAll>
</Directory>
```

- Con el Require all denied, restringimos el acceso a todo el mundo

- Require all granted daria acceso a todo el mundo


- Añadimos nuestra IP para tener el acceso permitido
```
<Directory "/var/www/clientes/gestion">
    <RequireAll>
        Require ip 192.168.1.151 (nuestra ip en local)
    </RequireAll>
</Directory>
```
- Ahora solo podriamos entrar con nuestra IP

- Con Require no ip denegariamos el acceso a una IP concreto en el que esten todos permitidos

- Para permitir a un rango de IPs:
Require ip 192.168.1  o Require ip 192.168.1.0/255.255.255.0 o Require ip 192.168.1.0/24 (todas las que deriven de ahi tendran permiso)

- Y reiniciamos el servidor:
```
sudo systemctl reload apache2
```

 ## Control de acceso a nivel de carpeta (.htaccess)

```
sudo mkdir /var/www/alumnos/secret_files
```

```
sudo nano /var/www/alumnos/secret_files/secret_text.txt
```

- Modificamos el archivo de configuración de clientes

```
sudo nano /etc/apache2/sites-available/alumnos.conf
```

- Añadimos para ver el indexado:
```
<Directory "/var/www/clientes/testhtaccess">
    AllowOverride All
    Options Indexes (solo funciona si no hay un index.html)
</Directory>
```

- Reiniciamos el servidor:
```
sudo systemctl reload apache2
```

- Y ahora podemos ver el indexado:
```
alumnos.com/secret_files
```

- Para restringir el acceso a la carpeta añadimos el archivo htaccess
```
sudo nano /var/www/alumnos/secret_files/.htaccess
```

- Añadimos Require all denied a pelo:
```
Require all denied
```

## Configuración de SSL (Secure Sockets Layer) en apache

- Con SSL configurariamos la conexión segura

- Significa que el servidor al que nos estamos conectamos esta espeficicando quien es

- Vamos a habilitar la conexión SSL en nuestro servidor generando un certificado autofirmado

- Activamos el servidor de SSL que ya está instalado por defecto.
```
sudo a2enmod ssl
```

### Crear una clave privada

```
openssl genrsa -out certificado.key 2048
```

- Tenemos que estar en el directorio del usuario ( $ )

### Crear un archivo csr

```
openssl req -new -key certificado.key -out certificado.csr
```

- Ponemos de contraseña patata

### Crear un archivo crt

```
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```

### Agregar el certificado al servidor apache

- Copiar los certificados a los directorios conrrespondientes
```
sudo cp certificado.crt /etc/ssl/certs

sudo cp certificado.key /etc/ssl/private
```

- Configurar el archivo ssl para que detecte los certificados
```
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

- Cambiamos la linea SSLCertificateFile y SSLCertificateKeyFile a esto:
```
SSLCertificateFile /etc/ssl/certs/certificado.crt

SSLCertificateKeyFile /etc/ssl/private/certificado.key
```

- Reiniciamos apache

```
sudo systemctl reload apache2
```

### Configuramos el Firewall

```
sudo ufw enable
```
 
 - Activamos el Apache Full para activar el https.

 ```
 sudo ufw allow 'Apache Full'
 ```

- Añadimos el VirtualHost 443 el archivo de configuración de la página a la que queremos acceder por https

```
sudo nano /etc/apache2/sites-available/alumnos.conf
```
```
<VirtualHost *:443>
    DocumentRoot /var/www/alumnos
    ServerName alumnos.com
    SSLEngine On
    SSLCertificateFile /etc/ssl/certs/certificado.crt
    SSLCertificateKeyFile /etc/ssl/private/certificado.key
</VirtualHost>
```

- Reiciamos apache
```
sudo systemctl reload apache2
```

### Acceso a la página

- Podemos acceder a la página mediante:
```
https://alumnos.com
```

- El navegador nos pondrá un problema de que el certificado lo hemos firmado nosostros mismos

- Vamos a Avanzado y le damos a Aceptar el riesgo y continuar

- Por último para que al poner alumnos.com se redirecciones automaticamente al https, en el archivo de configuración hacemos un redirect en el puerto 80

```
sudo nano /etc/apache2/sites-available/alumnos.conf
```
```
<VirtualHost *:80>
    DocumentRoot /var/www/alumnos
    ServerName alumnos.com
    Redirect / https://alumnos.com
</VirtualHost>
```

- Reiniciamos apache
```
sudo systemctl reload apache2
```
- Ya podemos acceder por conexión https con la ruta alumnos.com

---
# Instalación de PHP y sus configuraciones

```
sudo apt install php libapache2-mod-php php-mysql
```

## Añadir una página de PHP con BBDD
```
sudo nano /var/www/alumnos/index.php ( también podemos poderlo en la carpeta html para que sea por defecto con la ip del servidor )
<?php phpinfo(); ?>
```

- Reiniciamos apache
```
sudo systemctl reload apache2
```

- Instalamos la Base de Datos
```
sudo apt install mariadb-server
```

- Configurar la seguridad de la BBDD
```
sudo mysql_secure_installation
```

- Cuando pide contraseña ponemos enter solamente, y luego le damos a hacer un set de contraseña y ponemos la que queramos, despues sí a todo.

- Entrar al gestor bases de datos:
```
sudo mysql -u root -p

show DATABASES;
CREATE DATABASE examen_db;
```


- Para salir del gestor
```
quit
```

## Instalación de phpmyadmin

```
sudo apt install phpmyadmin
```

- Marcar la opción de apache 2 en la instalación

- Al final de la instalación pide configurar unos asuntos, marcamos No, para que lo configure automáticamente.

- Pasar el archivo de configuración de phpmyadmin a las siguientes carpetas:
```
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo ln -s /etc/apache2/conf-available/phpmyadmin.conf /etc/apache2/conf-enabled/phpmyadmin.conf
```

- Reiniciar apache

```
sudo systemctl reload apache2
```

- Ahora podemos acceder a la página de phpmyadmin
```
(nuestraip)/phpmyadmin
```
