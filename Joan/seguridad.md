# SEGURIDAD EN APACHE
1. Autenticación básica
1. Autenticación Digest
1. Control de acceso
1. Control de acceso a nivel de carpeta (.htaccess)
1. Configuración de SSL (Secure Sockets Layer) en apache
    1. Crear una clave privada
    1. Crear archivo .csr
    1. Crear certificado
    1. Agregar el certificado al servidor
1. Más cosas de seguridad


## AUTENTICACIÓN BÁSICA
1. Crear una página en la página de (clientes en aquest cas) y crear un primera página
1. Crear un arxiu amb les contrasenyes: sudo htpasswd -c /etc/httpd/password/passwords-admin admin
    * -c per a crear-lo, una vegada estiga creat no és necessari

1. Cambiar la configuració de la pàgina (de la principal, no de la creada) i afegir:
```
<Directory "/var/www/clientes/admin">
   AuthType Basic
   AuthName "Administrador"
   #Nom que surtira (sense rellevancia)	  
   AuthUserFile /etc/httpd/password/passwords-admin
   #Arxiu on estan els usuaris   
   Require valid-user
   #Es deixa entrar tots els usuaris valids
   #Require user admin
   #Només podría accedir el usuari admin
</Directory>
```

## Autentificación Digest
1. Crear una página en la página de (proveedores) y crear un primera página

1. Crear un arxiu amb les contrasenyes: sudo htdigest -c /etc/httpd/password/digest "administradores" admin
    * -c per a crear-lo, una vegada estiga creat no és necessari
    * "administradores" es el grup de usuaris que creem

1. Cambiar la configuració de la pàgina (de la principal, no de la creada) i afegir:

```
<Directory "/var/www/proveedores/admin">
   AuthType Digest
   AuthName "administradores"
   AuthUserFile /etc/httpd/password/digest
   Require valid-user # o Require user <nom-usuari>
</Directory>
```

    * AuthName ha de coincidir amb el grup amb del usuari


## Control de acceso

1. Crear una página en la página de (clientes) y crear un primera página

1. Cambiar la configuració de la pàgina (de la principal, no de la creada) i afegir:
```
#Restringir el acceso mediante direcion ip
<Directory "/var/www/clientes/gestion">
   <RequireAll>
       # Bloquejar totes: Require all denied
       Require ip <IP>

       # Require not ip <IP> restringe una ip para que no pueda ver la pagina
   </RequireAll>
</Directory>

```
Per a restringir rangos de IPs
Require ip 192.168.1 = Require ip 192.168.1.0/255.255.255.0 = Require ip 192.168.1.0/24


## Control de acceso a nivel de carpeta (.htaccess)
1. Mateix procediment que les vegades anteriors
1. Configuració .conf:
```
<Directory "/var/www/clientes/testhtaccess">
   AllowOverride All
   Options Indexes
</Directory>
```
1. Crear un arxiu anomenat .htaccess en la carpeta a configurar
```
#No fa falta posar la etiqueta '<Directory>'
Require all denied
```
    *No es pot revisar la syntasix d'aquets documents

## Configuración de SSL (Secure Sockets Layer) en apache
 * *El servidor es el que dice ser. utilizar una entidad certificadora que certifica que somos quiens somos*

Nota: ** si fa falta instal·lar-lo: ```sudo yum install openssl``` **

### 1 Crear una llave privada
1. Generar la llave: ```openssl genrsa -out <nombre>.key 2048```

### 2 Crear archivo .csr
1. Generar la llave:```openssl req -new -key <nombre>.key -out <nombre>.csr```

### 3 Crear certificado
1. Crear el certificad (.crt): ```openssl x509 -req -days 90 -in <nombre>.csr -signkey <nombre>.key -out <nombre>.crt```

### 4 Agregar el certificado al servidor Apache
1. instal·lar el mòdul d'Apache que gestiona les connexions segures:```sudo yum install mod_ssl```
1. moure els arxius .crt i .key anteriorment generats:
    * ```sudo cp certificado.crt /etc/pki/tls/certs```
    * ```sudo cp certificado.key /etc/pki/tls/private```
1. Modificar /etc/httpd/conf.d/ssl.conf per a indicar on estan el arxius, buscar (^W) **SSLCertificateFile** i **SSLCertificateKeyFile**.
1. Obrir el port :```sudo firewall-cmd --zone=public --add-service=https --permanent```
    * Recorda que fa falta recargar el firewall: ```sudo firewall-cmd --reload```
1. Afegir a la configuracio de la pag: 'Redirect / https://clientes.com' per a que redireccione per https
