# daw2-daw-1920

## Clase 1

- Crear una cuenta en GitHub
- Crear un nuevo repositorio: daw2-daw-1920
- Instalar git 
- Si aparece un error _"no se pudo bloquear /var/lib/dpkg/lock"_ ..., introducir la siguiente instrucción:
    ```
    sudo fuser -vki /var/lib/dpkg/lock
    ```
    y volver a instalar git:

    ```
    sudo apt install git
    ```
### Instrucciones básicas git

- Clonar el repositorio remoto:
    ```
    git clone "url"
    ```
- Ver estado del repositorio local
    ```
    git status
    ```
- Hacer un *commit* (comprometer) los cambios al repositorio local
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

### Añadir clave SSH a GitHub

En primer lugar generamos una clave. De todo lo que nos pide, sólo introducimos nuestro email, lo demás todo con intros vacias:   
```   
ssh-keygen -t rsa -b 4096 -C "tucorreo@gmail.com"
```
Una vez generada la clave, la copiamos al portapapeles. Para ello, mostramos la clave por la consola del sistema, y luego la copiamos:
```
cat ~/.ssh/id_rsa.pub
```
