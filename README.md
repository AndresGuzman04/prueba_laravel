# Prueba Laravel

## Dependencias

-  Se debe tener instalado [XAMPP](https://www.apachefriends.org/es/download.html "XAMPP") (versión **PHP** **8.2** o superior)

-  Se debe tener instalado [Composer](https://getcomposer.org/download/ "Composer")

  

## Como instalar en Local

1.  Clone  o  descargue  el  repositorio  a  una  carpeta  en  Local

  

1.  Abra  el  repositorio  en  su  editor  de  código  favorito  (**Visual  Studio  Code**)

  

1.  Ejecute  la  aplicación  **XAMPP**  e  inice  los  módulos  de  **Apache**  y  **MySQL**

  

1.  Abra  una  nueva  terminal  en  su  editor

  

1.  Compruebe  de  que  tiene  instalado  todas  dependencias  correctamente,  ejecute  los  siguientes  comandos:  **(Ambos  comandos  deberán  ejecutarse  correctamente  -  ejecutar  en  la  terminal)**

```bash

php  -v

```

```bash

composer  -v

```

  

1.  Ahora  ejecute  los  comandos  para  la  configuración  del  proyecto  (**ejecutar  en  la  terminal**):

  

-  Este comando nos va a instalar todas la dependencias de composer

```bash

composer install

```

-  En el directorio raíz encontrará el arhivo **.env.example**, dupliquelo, al archivo duplicado cambiar de nombre como **.env**, este archivo se debe modificar según las configuraciones de nuestro proyecto. Ahí se muestran como debería quedar

```bash

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=facturasmart

DB_USERNAME=root

DB_PASSWORD=

```

-  Ejecutar el comando para crear la Key de seguridad

```bash

php artisan key:generate

```

  -  Ejecute el proyecto (en otra terminal)

```bash

php artisan serve

```
