Seguridad
1. Autenticacion basica
2. Autenticacion Digest
3. Control de acceso
4. Control de acceso a nivel de carpeta (.htacces)
5. Configuracion de SSL en apache
   - Crear una clave privada
   - Crear archivo csr
   - Crear certificado crt
   - Agregar el certificado al servidor Apache

-------------------------------------------------

- Crear carpeta para guardar contraseñas
sudo mkdir /etc/httpd/password

- Crear fichero de contraseñas
sudo htpasswd -c /etc/httpd/password/passwords-admin admin

- Autenticacion Basica para restringir el acceso a una carpeta
<Directory "/var/www/clientes/admin">
    AuthType Basic
    AuthName "Administrador"
    AuthUserFile /etc/httpd/password/passwords-admin
    Require valid-user
</Directory>

- Todos los usuarios
Require valid-user 

- Solo al usuario admin
Require user admin 

- Autenticacion Digest
sudo htdigest -c /etc/httpd/password/digest "administradores" admin

<Directory "/var/www/proveedores/admin">
    AuthType Digest
    AuthName "administradores"
    AuthUserFile /etc/httpd/password/digest
    Require user admin
</Directory>

- Control de acceso, restringir a todos o permitir por ip
<Directory "/var/www/clientes/gestion">
    <RequireAll>
       # Require all denied
       	Require	ip 192.168.1.157
    </RequireAll>
</Directory>

- Denegar el acceso a una ip
<Directory "/var/www/clientes/gestion">
    <RequireAll>
       # Require all denied
        Require all granted
        Require not ip 192.168.1.157
    </RequireAll>
</Directory>

- Permitir a un rango de ip
<Directory "/var/www/clientes/gestion">
    <RequireAll>
        Require ip 192.168.1
    </RequireAll>
</Directory>

- Control de acceso a nivel de carpeta (.htaccess)
Poner lo siguiente en el archivo de confirguracion de la carpeta
<Directory "/var/www/clientes/testhtaccess">
    AllowOverride All
    Options Indexes
</Directory>

- En el archivo .htaccess poner lo siguiente para denegar  el acceso
Require all denied

- Atención:
Crear un archivo .htaccess en el directorio de la web y usar las declaraciones anterirores para permitir o denegar

- Configuracion de SSL en apache
sudo yum install openssl

- Crear el certificado
openssl genrsa -out certificado.key 2048
openssl req -new -key certificado.key -out certificado.csr
openssl x509 -req -days 90 -in certificado.csr -signkey certificado.key -out certificado.crt

- Instala el modulo ssl de apache
sudo yum install mod_ssl 

- Copiar los certificados en su carpeta correspondiente
sudo cp certificado.crt /etc/pki/tls/certs
sudo cp certificado.key /etc/pki/tls/private

- Modificar el fichero de configuracion de ssl para indicar donde estan los certificados
sudo nano /etc/httpd/conf.d/ssl.conf

- Atencion cambiar:
SSLCertificateFile /etc/pki/tls/certs/certificado.crt
SSLCertificateKeyFile /etc/pki/tls/private/certificado.key

sudo firewall-cmd --zone=public --add-service=https --permanent
sudo firewall-cmd --reload

- Redireccion a https
<VirtualHost *:80>
    DocumentRoot /var/www/clientes
    ServerName clientes.com
    Redirect / https://clientes.com
</VirtualHost>

