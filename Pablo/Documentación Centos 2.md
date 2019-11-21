# Documentación instalar Apache en Centos y configurarlo

-----Desde la consola de Centos-----
- Cambiar un fichero onboot:
```
sudo vi /etc/sysconfig/network-scripts/ifcfg-enp<TAB>"Hacer un tabulador"
```
-Al insertarlo aparecerá un menu (archivos de configuración de red), con pulsar "i" se podrá editar en el menu. Cambiar la ultima opción de "no" a "yes". Para que arranque la red. "ESC" salir modo edición. ":wq" para salir y guardar, dar a intro.

- Reiniciar y comprobar el servicio de red:
```
sudo service network restart
ping google.com
```
-Control c para finalizar el ping

- Instalar Apache:
```
sudo yum install httpd
```

- Consultar el estado de Apache:
```
systemctl status httpd
```

- Poner en marcha Apache:
```
sudo systemctl start httpd
```

- Apagar la MV:
```
sudo shutdown
```

# Conectarse desde la terminal local al servidor

- Cambiar la red de Centos ha adaptador puente para conectarse al servidor mediante una IP.

- Comprobar dirección IP:
```
ip addr show
Apuntar la IP 192.168.1.182/24 brb  192.168.1.255
```
-----Desde la consola de ubuntu-----

- Todo lo que se realice en el terminal se realiza en la del servidor.
- Asi podemos comprobar Apache desde la consola del Host(Ubuntu).
```
ssh pablo@192.168.1.182
```
- Poner en marcha Apache y comprobar que runnea.
```
sudo systemctl start httpd
systemctl status httpd

```

- Añadir regla de firewall para que permita http:
```
sudo firewall-cmd --zone=public --add-service=http --permanent
```
- Recargar firewall:
```
sudo firewall-cmd --reload
```
- Buscar en el navegador la IP del servidor 192.168.1.182

- Saber la versión de Centos:
```
cat /etc/*-release
```

- Parar servidor:
```
sudo apachectl stop
```

- Arrancar o reiniciar servidor:
```
sudo apachectl start
sudo apachectl restart
```

- Ver estado de Apache (El otro tambien funciona)
```
sudo apachectl status
```
- Espera a que acaben las conexiones y luego reinicia:
```
sudo apachectl graceful
```

- Convertir en servicio a habilitable el servidor Apache:
```
sudo systemctl enable httpd
```
- Versión apache:
```
httpd -v
httpd -V
```

# Instalar manual
- Instalar manual:
```
sudo yum install httpd-manual
```

- Acceder al manual en el navegador IP/manual, reinicar antes Apache.
```
sudo apachectl restart
ip/manual
```

# Poner un nombre al servidor y que devuelva la IP buscada por el nombre
- Salir de consola del servidor
```
exit
```
- Entrar y añadir nuestra ip del servidor y ponerle un nombre
```
sudo nano /etc/hosts
```

- Volver al servidor:
```
ssh pablo@miservidor
```

- Instalar nano para editar archivos.
```
sudo yum install nano
```
- Visualizar nano
```
sudo nano /etc/hostname
``` 

# Archivos de Apache
- Localización de configuración de Apache:
```
ll /etc/httpd
```
- Archivo configuración del servidor:
```
sudo nano /etc/httpd/conf/httpd.conf
```

# Subir archivos a Servidor
- Descargar Filezilla:
```
sudo apt instal filezilla
```
- Configurar conexión al servidor.
Arriba a la izquierda crear nuevo sitio.
Poner nombre ,contraseña ,normal y conectar.

- Crear una carpeta desde el servidor:
```
mkdir Descargas
```

- Guardar web de ejemplo en la carpeta Descargas del servidor
```
Buscar en Filezilla en Descargas local el archivo Web y arrastralo a la Descargas del servidor
```
- Desde el servidor descomprimir el zip en Descargas(Instalar unzip):
```
sudo yum install unzip
cd Descargas
unzip "Nombre archivo"
```
