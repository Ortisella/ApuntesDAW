# Servidor Ubuntu

### Instalamos actualizaciones del sistema
```
sudo apt upgrade
```
# Instalamos apache

```
sudo apt install apache2
```

# Configurar el cortafuegos

```
sudo ufw app list
```

### Se debería desplegar una lista de perfiles de aplicación:

```
Salida
Available applications:
  Apache
  Apache Full
  Apache Secure
  OpenSSH
```

### Se recomienda que siempre habilites el perfil con más restricciones dependiendo del tráfico requerido y cómo se ha configurado tu máquina. Como aún no hemos configurado el SSL para nuestro servidor en esta guía, solo permitiremos el tráfico a través del puerto 80:

```
sudo ufw allow 'Apache'
```

### Se puede verificar el cambio digitando:

```

sudo ufw status
```

### Verificar el servidor web

```
sudo systemctl status apache2
```

# Administrando el proceso de Apache

### Para detener tu servidor web, digita:
```
sudo systemctl stop apache2
```

### Para iniciar tu servidor web, digita:

```
sudo systemctl start apache2
```

### Para detener y reiniciar el servicio en un solo paso, puedes ingresar:

```
sudo systemctl restart apache2
```

### Si únicamente estás realizando cambios en la configuración, puedes recargar Apache sin necesidad de perder las conexiones que pudieran estar activas. Para ello, usa el comando:

```
sudo systemctl reload apache2
```
### Por defecto, Apache se configura para iniciarse automáticamente cuando el servidor arranca. Si no se quiere esto, se puede deshabilitar este comportamiento, ingresando:
```
sudo systemctl disable apache2
```

### Para rehabilitar el servicio durante el arranque, digita:
```
sudo systemctl enable apache2
```

# Configuramos virtulHost

```
/etc/apache2/sites-available
```

![imagen virtualhost](images/virtualhost.png)

### Habilitamos el sitio creado

```
sudo a2ensite profesores.conf
```

![imagen habilitar virtualhost](images/habilitamos-virtualhost.png)

### Reiniciamos apache
```
sudo service apache2 restart
```

### Recargamos apache

```
sudo systemctl reload apache2
```

# Configurar host maquina loca (no servidor)

```
sudo /etc/hosts
```

![imagen host](images/host.png)

# Configurar ip estatica con dos ips

### hay que habilitar otro adaptador puente en virtualbox

```
sudo vi /etc/netplan/50-cloud-init.yaml
```

### configuración estatica

```
network:
    ethernets:
        enp0s3:
            dhcp4: no
            addresses: [192.168.1.137/24]
            gateway4: 192.168.1.1
            nameservers:
                addresses: [8.8.8.8,8.8.4.4]
            optional: true
        enp0s8:
            dhcp4: no
            addresses: [192.168.1.138/24]
            gateway4: 192.168.1.1
            nameservers:
                addresses: [8.8.8.8,8.8.4.4]
            optional: true

    version: 2

```

### ponemos las ips en el virtualhost

![imagen host](images/ip-virtualhost.png)

# Crear distintos puertos en virtulhost

### En el virtual host

![imagen host](images/puertos.png)


# Restricciones a paginas

### Creamos el directorio para guardar las contraseñas

```
sudo mkdir /etc/apache2/password
```

### Creamos el usuario y la contraseña

```
sudo htpasswd -c /etc/apache2/password/passwords-admin admin
```
#### passwords-admin -> es el archivo a guardar
#### admin -> es el usuario

### Vemos el archivo creado con el ususario

```
cat /etc/apache2/password/passwords-admin
```

### configuramos el directorio para el admin

```
Listen 8082
<VirtualHost 192.168.1.138:8082>
        ServerName profesores.com
        DocumentRoot /var/www/html/profesores
</VirtualHost>
<Directory "/var/www/html/profesores/administracion.html">
        AuthType Basic
        AuthName "Administrador"
        AuthUserFile /etc/apache2/password/passwords-admin
        Require user admin
</Directory>
```

### comprobamos la configuracón

```
sudo apachectl configtest
```


### Reiniciamos el servidor
```
sudo service apache2 restart
```

### Solo podemos entrar desde la maquina local
```
Listen 8082
<VirtualHost 192.168.1.138:8082>
        ServerName profesores.com
        DocumentRoot /var/www/html/profesores
</VirtualHost>
<Directory "/var/www/html/profesores/admin">
        AuthType Basic
        AuthName "Administrador"
        AuthUserFile /etc/apache2/password/passwords-admin
        Require user admin
</Directory>
<Directory "/var/www/html/profesores">
        <RequireAll>
                Require ip 192.168.1.128
        </RequireAll>
</Directory>
```

# Indexear el contenido

### En el virtual host

```
<Directory "/var/www/html/alumnos/secret_file">
        AllowOverride All
        Options Indexes
</Directory>
```

### Crear .htaccess

```
Require all denied
```

# Configurar ssl domain

### activamos el modulo
```
sudo a2enmod ssl
```
### si no esta instalado ssl 
``` 
sudo apt install openssl
```
### creamos la clave privada 
```
openssl genrsa -out certificado.key  2048
````
### creamos el csr clave privada
```
openssl req -new -key certificado.key -out certificado.csr
```

### Generamos un crt
```
sudo openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```

### copiamos certificados
```
sudo cp certificado.key /etc/ssl/private
sudo cp certificado.ctr /etc/ssl/certs
```

### lugo tenemos que ir a default-ssl.conf y modificar estas lineas
```
sudo vi default-ssl.conf
SSLCertificateFile      /etc/ssl/certs/certificado.crt
SSLCertificateKeyFile /etc/ssl/private/certificado.key
```

### luego configuramos en el virtualhost
```
<VirtualHost 192.168.1.137:8081>
    ServerName alumnos.com
    DocumentRoot /var/www/html/alumnos
    Redirect permanent / https://alumnos.com
</VirtualHost>
<Directory "/var/www/html/alumnos/secret_file">
    AllowOverride All
    Options Indexes
</Directory>
<VirtualHost 192.168.1.137:443>
    ServerName alumnos.com
    DocumentRoot /var/www/html/alumnos
    SSLEngine on
    SSLCertificateFile      /etc/ssl/certs/certificado.crt
    SSLCertificateKeyFile /etc/ssl/private/certificado.key
</VirtualHost>
```

# Instalar php y mysql

### php
```
sudo apt install php libapache2-mod-php php-mysql
```

### instalar mariadb
```
sudo apt install mariadb-server
```

### Poner contraseña root a mysql
``` 
sudo mysql_secure_installation
```

### Instalar phpmyadmin
```
sudo apt install phpmyadmin
```

# Error no entra en mysql

### primero entramos como root
```
sudo mysql -u root -p
```

### Una vez que hemos accedido al servidor, seleccionamos la base de datos mysql

```
USE mysql;
```

### Listamos el contenido de los campos user y plugin:

```
SELECT user, plugin FROM user;
```
### Actualizamos de unix_socket a mysql_native_password:

```
UPDATE user SET plugin="mysql_native_password" WHERE user="root";
```

### Comprobamos los cambios listando de nuevo los campos user y plugin:

```
SELECT user, plugin FROM user;
```
### Forzamos al servidor a recargar los privilegios de los usuarios, logrando que los cambios surtan efecto tras la ejecución de la sentencia sin necesidad de reiniciar el servidor:

```
FLUSH PRIVILEGES;
```

### Cerramos la conexión con el servidor y cerramos el cliente:

```
exit;
```

### ahora nos debería dejar entrar en phpmyadmin