## CANVIAR LA ASSIGNACIÓ DE IP
+ carpeta de configuració d'internte: `/etc/netplan/`
+ arxiu : `/etc/netplan/50-cloud-init.yaml configuració`
+ final:
```
network:
    ethernets:
        enp0s3:
#            dhcp4: true
             addresses: [192.168.1.182/24]
             gateway4: 192.168.1.2
             dhcp4: no
             nameservers:
                    addresses: [8.8.8.8,8.8.4.4]
             optional: true
    version: 2
```
reiniciar la configuració d'internet: `sudo netplan apply` o `sudo netplan --debug apply`

## FIREWALL (ufw)
 + `sudo ufw status`
 + `sudo ufw enable`
 + `sudo ufw app list`: muestra la lista de aplicaciones permitidas por el firewall
 + `sudo ufw allow <pot>`: per a permetre la communicació per el port!!!!
 + `sudo ufw allow 'Apache Full'`: per a permetre a apache

  * digital ocean: https://www.digitalocean.com/community/tutorials/how-to-set-up-a-firewall-with-ufw-on-ubuntu-16-04
  * hotpresto: https://hostpresto.com/community/tutorials/install-and-configure-ufw-firewall-on-ubuntu-16-04/

## APACHE
+ `sudo apt install apache2`
+ `systemctl status apache2`: mostra el estat actual d'Apache
+ `sudo apachectl stop`: para apache
+ `sudo apachectl start`: inicia apache
més restart i gratefull com en centos

+ habilitar apahce al firewall: `sudo ufw allow 'Apache'`

+ `cat /etc/*-release`: trau la informació del sistema
+ `sudo apt install apache2-doc`: instal·la el manual d'apache

## Arxius de configuració
 + `/etc/apache2` -> arxius de configuració
 + `/etc/apache2/sites-available` -> arxius de configuració dels sites
 + `/var/www/`-> DocumentRoot (com en centos)
## Comandos per habilitar/deshabilitar
 + `sudo a2ensite` habilitar el lloc web (després s'ha de fer un reload: `systemctl reload apache2`)

 + `sudo a2dissite` per a deshabilitar el lloc
