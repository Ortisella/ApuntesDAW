# DAW
Documentación en curso

# Clase 1

- Crear una cuenta en github
- Crear un nuevo repositorio: daw
- instalar git
- Si aparece un error "no se pudo bloquear /var/lib/dpkg/lock" ..., introducir la siguiente instrucción:

```
sudo fuser -vki /var/lib/dpkg/lock
```

y volver a instalar git.

```
sudo apt install git
```

### Instrucciones básicas git
- Clonar el repositorio remoto
```
git clone url
```

- Ver estado del repositorio local
```
git status
```

- Hacer un "commit" (comprometer) los cambios al repositorio local
```
git commit -am "mensaje"
```

- Subir (push) los cambios del repositorio local al repositorio remoto:
```
git push origin master
```

- Actualizar (pull) el repositorio local con los cambios desde el repositorio remoto
```
git pull origin master
```

### Añadir clave ssh a github

En primer lugar instalamos openssh-server:
```
sudo apt install openssh-server
```

Después generamos una clave:
```
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
```
Una vez generada la clave, la copiamos al portapapeles. Para ello, mostramos la clave por la consola del sistema, y luego la copiamos:
```
cat ~/.ssh/id_rsa.pub
```
y la añadimos a github (settings -> SSH and PGP keys)

Arrancamos el agente "ssh" en segundo plano:
```
eval "$(ssh-agent -s)"
```

y ahora añadimos la clave al agente:
```
ssh-add ~/.ssh/id_rsa
```

Para que github acepte la conexión ssh hay que modificar la direccion "origin". Para ver la dirección actual:
```
git remote show origin
```

Esto nos mostrará un mensaje similar a este:
```
URL  para obtener: https://github.com/calaespi/daw.git
URL para publicar: https://github.com/calaespi/daw.git
```

Ahora hay que modificar esta dirección añadiendo la opcion "ssh":
```
git remote set-url origin git+ssh://git@github.com/calaespi/daw.git
```

## Instalación de virtualbox
Primero instalamos las dependencias:
```
sudo apt install libcurl4 libqt5opengl5 libqt5printsupport5
```

- Descargamos virtualbox y el extension pack desde la página de descargas de www.virtualbox.org
- Ejecutamos el archivo .deb descargado:
```
sudo dpkg -i fichero
```

# Clase 2

## Trabajar con usuarios
Añadir usuario
```
sudo adduser victor
```

Añadir un usuario como administrador
```
sudo usermod -aG sudo victor
```

## Trabajar con ficheros
Crear un script
```
sudo nano script.sh
```

Añadir el permiso de ejecución a un fichero
```
chmod +x script.sh
```

## Trabajar con git
Añadir un archivo al repositorio
```
git add script.sh
```

Crear una rama para trabajar
```
sudo git branch nombre_rama
```

Cambiar entre ramas para trabajar en una u otra
```
sudo git checkout nombre_rama
```

Unir los cambios corregidos en una rama a la otra. Tenemos que estar en la rama en la cual queremos traer los cambios
```
sudo git merge nombre_rama
```

Mostrar las ramas que tenemos. La coloreada significa que estamos trabajando sobre esa rama
```
sudo git branch
```

Borrar una rama
```
sudo git branch -d nombre_rama
```