
# Despliegue de aplicaciones web
Documentacion del curso

### Creación de usuario
- sudo useradd "nombreusuario"
- sudo usermod -aG sudo "nombreusuario"

------
## Poner a punto el github
- Crear una cuenta en github
- Crear un nuevo
repositorio: daw-daw-1920
- Instalar git 
- Si aparece un error "no 
se pudo bloquear /var/lib/dpkg/lock" ..., introducir la siguiente instrucción:

```
sudo fuser -vki /var/lib/dpkg/lock
```

y volver a instalar git.

```
sudo apt install git
```
----
### Instrucciones básicas git
- Ver estado del repositorio local
```
git status
```

- Hacer un *commit*
(comprometer) los cambios al repositorio local
```
git commit -am "mensaje"
```

- Subir (push) los cambios del repositorio local el repositorio remoto:
```
git push origin master
```

- Actualizar (pull) el repositorio local con los cambios desde el repositorio remoto
```
git pull origin master
``` 
----
### Añadir clave ssh a github

- En primer lugar instalamos openssh-server:
```
sudo apt install openssh-server
```

- Despues generamos una clave:
```
ssh-keygen -t rsa -b 4096 -C "example@example.com"
```

- Una vez generada la clave, la copiamos al portapapeles. Para ello, mostramos la clave por la consola de sistema, y luego la copiamos:
```
cat ~/.ssh/id_rsa.pub
```

- Y la añadimos a github (**settings** -> **SSH and PGP keys**)

- Arrancamos el agente *ssh* en segundo plano:
```
eval "$(ssh-agent -s)"
```
- Y ahora añadimos la clave al agente:
```
ssh-add ~/.ssh/id_rsa
```

- Ahora ya podemos clonar la carpeta del git en un repositorio local con la ruta generada por ssh del git

```
git clone "rutadelgit"
```
-----

## A partir de aquí es para poder utilizar la ruta que no es de ssh (no hace falta)

- Para que github acepte la conexión ssh hay que modificar la dirección origin. Para ver la url actual:
```
git remote show origin
```
- Esto nos mostrara un mensaje similar a este:
```
URL  para obtener: https://github.com/cristianlazaro16071996/daw2.git
URL para publicar: https://github.com/cristianlazaro16071996/daw2.git
```

- Ahora hay que modificar esta dirección añadiendo la opción *ssh*:
```
git remote set-url origin git+ssh://git@github.com/tu-usuario/daw2.git
```

------
## Instalación de virtual box

- Primero instalamos las dependencias:
```
sudo apt install libcurl4 libqt5opengl5 libqt5printsupport5
sudo apt install gcc make perl
```

- Descargamos virtualbox y el *extension pack* desde la página de descargas de www.virtualbox.org

- Ejecutamos el archivo .deb descargado:
```
sudo dpkg -i virtualbox-6.0_6.0.12-133076~Ubuntu~bionic_amd64.deb
```
- Despues hacer doble click en el archivo de la extensión

- A continuación agregamos el flameshot:

```
sudo apt install flameshot
```



