# daw2-daw-1920

# INDICE
- [Primera clase](#clase-1)
- [Añadir clave ssh a github](##Añadir-clave-ssh-a-github)
- [Instrucciones básicas git](##Instrucciones-básicas-git)
- [Ejemplos de Ejercicios](Ejemplos_ejercicios.md)
- [Ejercicio1](Ejercicio1.md)
- [InstalarCentos](InstalarCentOS.md)
- [InstalarUbuntuServer](InstalarUbuntuServer.md)
- [Docker](Docker.md)
- [Otros](Otros.md)

## clase 1

- Crear una cuenta en github
-Crear un nuevo repositorio: daw2-daw-1920
- instalar git
- Si aparece un error "No se puedo bloquear /var/lib/dpkg/lock" ..., introducir la siguiente intrucción:

```
sudo fuser -vki /var/lib/dpkg/lock
```

y volver a instalar git.

```
sudo apt install git
```

## Añadir clave ssh a github

- En primer lugar istalamos openssh-server:
```
sudo apt install openssh-server
```
- Después generamos una clave:
```
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
```
- Una vez generada la clave, la copiamos al portapapeles. Para ello, mostramos la clave por la consola del sistema, y luego la copiamos:
```
cat ~/.ssh/id_rsa.pub
```

- y la añadimos a github (**settings** -> **SSH and PGP keys**)

- Arrancamosel agente *ssh* en segundo plano:
```
eval "$(ssh-agent -s)"
```

- y ahora añadimos la clave al agente:
```
ssh-add ~/.ssh/id_rsa
```

- Clonar el repositorio remoto
```
git clone url
```

## A partir de aquí es para poder utilizar la ruta que no es de ssh (no hace falta)

- Para que github acepte la conexión ssh hay que modificar ladirección *origin*. Para ver la url actual:
```
git remote show origin
```

- Esto lo mostrará un mensaje similar a este:
```
URL  para obtener: https://github.com/dante0507/daw2-daw-1920.git
URL para publicar: https://github.com/dante0507/daw2-daw-1920.git
```
- Ahora hay que modificar esta dirección añadiendo la opción *ssh*:
```
git remote set-url origin git+ssh://git@github.com/tu-usuario/daw2-daw-1920.git
```

## Instrucciones básicas git

- Ver estado del repositorio local
```
git status
```

- Hacer un *commit* (comprometer) los cambios al repositorio local
```
git commit -am "mensaje"
```

- Subir (push) los cambios del repositorio local elrepositorio remoto:
```
git push origin master
```

- Sincronizar local con archivo en github:
```
git fetch
```

- Actualizar (pull) el repositorio local con los cambios desde el repositorio remoto
```
git pull origin master
```