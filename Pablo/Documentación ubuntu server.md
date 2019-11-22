# Documentación 5 

## Instalar ubuntu server
-Descargar Ubuntu Server 18.04 LTS

-Crear una nueva maquina virtual con ubuntu server, poner 4 gb de ram

-Poner español y darle intro a todo  y continuar

-Marcar la casilla de ssh

-No marcar ningún paquete y darle ha hecho

-Reboot y reiniciar cuando se bloquee en dos "OK"

-Cambiar la maquina virtual a adaptador puente, y hacer un "reboot"

-Conectarse a servidor por ssh:
```
ip addr show
ssh pablo@192.168.1.175
```

## Configurar IP stática: (En clase Gateway 1.2)
-Buscar archivo y configurarlo:
```
ll /etc/netplan/
sudo nano /etc/netplan/50-cloud-init.yaml
```

-Modificarlo asi:
```
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

-Reiniciar y aplicar los cambios:
```
sudo netplan apply
sudo reboot
```

# Abir terminal y cambiar el archivo hosts
-Añadir ip host para entrar mediante el nombre
```
sudo nano /etc/hosts

127.0.0.1       localhost
127.0.1.1       MateAulas
192.168.1.182   miservidor
192.168.1.182   clientes.com
192.168.1.182   proveedores.com

192.168.1.175   ubuntu-server
```

## Firewall ubuntu
-Habilitar y activar firewall
```
sudo ufw status
sudo ufw enable
```
-Para más información:
```
sudo ufw status verbose
sudo ufw app list
```

## Instalar apache
-Instalar servidor apache
```
sudo apt install apache2
```

-Ver el estado de apache:
```
systemctl status apache2
```

-Iniciar el servidor:
```
sudo apachectl start
```

-Parar servidor:
```
sudo apachectl stop
```
-Caracteristicas del servidor:
```
cat /etc/*-release
```
Instalar manual:
```
sudo apt install apache2-doc
```
-Visualizar archivos de configuración
```
ll /etc/apache2
```

## Puerto 80
-Añadir regla:
```
sudo ufw allow 'Apache'
sudo ufw allow 'OpenSSH'
```
-Buscar en el navegador:
```
ubuntu-server/
```

# Simular varias Webs en el mismo servidor(VirtualHosts)
-Instalar unzip:
```
sudo apt install unzip
```
-Crear directorio Descargas y en filezilla poner la web.zip en Descargas del servidor:
```
mkdir Descargas
```
-Crear directorio alumnos en www:
```
sudo mkdir /var/www/alumnos
```

-Copiar los archivos de web.zip descomprimidos a alumnos:
```
unzip web_daw.zip //En descargas
sudo cp -R . /var/www/alumnos/ //En web_daw
```
-Modificar alumnos:
```
sudo nano /var/www/alumnos/index.html
```

-Configurar alumnos.conf
```
sudo nano /etc/apache2/sites-available/alumnos.conf
<VirtualHost *:80>
    ServerName alumnos.com
    DocumentRoot /var/www/alumnos
</VirtualHost>
```
-Comprobar que alumnos no esta activada y activarla (En Centos esto no se hace)
```
ll /etc/apache2/sites-enabled/
sudo a2ensite alumnos
```
-En el ordenador local en hosts añadir alumnos.com:
```
sudo nano /etc/hosts
127.0.0.1       localhost
127.0.1.1       MateAulas
192.168.1.182   miservidor
192.168.1.182   clientes.com
192.168.1.182   proveedores.com

192.168.1.175   ubuntu-server
192.168.1.175   alumnos.com

```
-Reiniciar apache:
```
systemctl reload apache2
sudo systemctl restart apache2
```
-Deshabilitar alumnos y comprobar que se deshabilita y no deja entrar por navegador:
```
sudo a2dissite alumnos
ll /etc/apache2/sites-enabled/
```

-Crear otro igual para profesores
