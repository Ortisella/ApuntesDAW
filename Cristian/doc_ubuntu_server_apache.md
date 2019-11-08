- [CONEXIÓN POR SSH A LA MÁQUINA VIRTUAL](#Conexión-por-SSH-a-la-máquina-virtual)
    - [Adaptador puente](#Adaptador-puente)
    - [Configurar la IP estática](#Configurar-la-IP-estática)
    - [Configuración de los hosts](#Configuración-de-los-hosts)
    - [Confgurar el Firewall](#Configurar-el-Firewall)

- [INSTALACIÓN DE APACHE EN UBUNTU-SERVER](#Instalación-de-Apache-en-Ubuntu-Server)
    
    
- [TRATAMIENTO DEL CONTENIDO DEL SERVIDOR CON FILEZILLA](#Añadir-el-servidor-a-FileZilla)

- [SIMULAR DISTINTAS WEBS SOPORTADAS POR EL MISMO SERVIDOR](#Simular-distintas-webs-soportadas-por-el-mismo-servidor)
    - [Configurar las webs](#Configurar-las-webs)
    



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

## Configuración de los hosts

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

- Creamos un nuevo sitio con el servidopr de ubuntu en Filezila con: SFTP y modo Normal, nuestra IP, usuario y contraseña

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

## Configurar las webs
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

