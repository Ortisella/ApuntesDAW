# Examen Victor

- Ver ip
```
ip addr show
```

- Conectar por ssh
```
ssh victor@192.168.1.148
```

- Instalar apache
```
sudo apt install apache2
```

- Crear carpeta viajes
```
sudo mkdir /var/www/viajes
```

- Subir la web de clientes de local al servidor
```
scp ./recursos_examen.zip victor@192.168.1.148:/home/victor/web/recursos_examen.zip 
```

- instalar unzip
```
sudo apt install unzip
```

- descomprimir
```
sudo unzip recursos_examen.zip
```

- copiar la web a la ruta clientes
```
sudo cp -R recursos_examen/* /var/www/viajes 
```

- Crear carpeta tienda
```
sudo mkdir /var/www/tienda
```

- copiar la web a la ruta tienda
```
sudo cp -R recursos_examen/* /var/www/tienda 
```

- Configuracion de la web de viajes
```
sudo nano /etc/apache2/sites-available/viajes.conf

<VirtualHost *:80>
    ServerName viajesvictor.com
    DocumentRoot /var/www/viajes
</VirtualHost>
```

- Configuracion de la web de tienda
```
sudo nano /etc/apache2/sites-available/tienda.conf

<VirtualHost *:80>
    ServerName tienda.com
    DocumentRoot /var/www/tienda
</VirtualHost>
```

- Configurar los hosts en local
```
sudo nano /etc/hosts

192.168.1.148   viajesvictor.com
192.168.1.148   tienda.com
```

- Habilitar la web viajes para poder verla
```
sudo a2ensite viajes
systemctl reload apache2
```

- Habilitar la web tienda para poder verla
```
sudo a2ensite tienda
systemctl reload apache2
```

- Autenticacion digest pagina tienda
```
sudo htdigest -c /etc/apache2/password/digest "administradores" admin
```

- configuracion digest en /etc/apache2/sites-available/tienda.conf
```
<VirtualHost *:80>
    ServerName tienda.com
    DocumentRoot /var/www/tienda
</VirtualHost>

<Directory "/var/www/tienda">
    AuthType Digest
    AuthName "administradores"
    AuthUserFile /etc/apache2/password/digest
    Require user admin
</Directory>
```

- habilitar digest
```
sudo a2enmod auth_digest
```

- reiniciar apache
```
systemctl restart apache2
```

- configuracion para acceder desde la ip de mi cliente solamente. Modificacion en el archivo /etc/apache2/sites-available/viajes.conf
```
<VirtualHost *:80>
    ServerName viajesvictor.com
    DocumentRoot /var/www/viajes
</VirtualHost>

<Directory "/var/www/viajes">
    <RequireAll>
       Require ip 192.168.1.154
    </RequireAll>
</Directory>
```

- reiniciar el servidor apache
```
systemctl restart apache2
```

- Crear carpeta settings en la web de viajes
```
sudo mkdir /var/www/viajes/settings
```

- crear archivo conf.txt
```
sudo nano /var/www/viajes/settings/conf.txt
```

- crear archivo .htaccess
```
sudo nano /var/www/viajes/settings/.htaccess
```

- poner lo siguiente para impedir el acceso a los usuarios en el fichero .htaccess
```
Require all denied
```

- para que .htaccess funcione cambiar en /etc/apache2/apache2.conf lo siguiente: AllowOverride None por AllowOverride All
```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All 
        Require all granted
</Directory>
```

- Configuracion de SSL en apache
```
sudo apt install openssl
```

- Crear el certificado
```
openssl genrsa -out certificado.key 2048
openssl req -new -key certificado.key -out certificado.csr
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt
```

- Copiar los certificados en su carpeta correspondiente
```
sudo cp certificado.crt /etc/ssl/certs
sudo cp certificado.key /etc/ssl/private
```

- Archivo a modificar para el SSL en Ubuntu
```
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

- Modificacion SSL Ubuntu
```
SSLCertificateFile /etc/ssl/certs/certificado.crt
SSLCertificateKeyFile /etc/ssl/private/certificado.key
```

- VirtualHost para SSL en el archivo /etc/apache2/sites-available/viajes.conf
```
<VirtualHost *:80>
    ServerName viajesvictor.com
    DocumentRoot /var/www/viajes
    Redirect permanent / https://viajesvictor.com
</VirtualHost>

<VirtualHost *:443>
    ServerName viajesvictor.com
    DocumentRoot /var/www/viajes
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/certificado.crt
    SSLCertificateKeyFile /etc/ssl/private/certificado.key
</VirtualHost>
```

- Permitir el puerto 443 en el firewall
```
sudo ufw allow 'Apache Secure'
```

- habilitar ssl
```
sudo a2enmod ssl
```

- reiniciar el servidor apache
```
systemctl restart apache2
```
