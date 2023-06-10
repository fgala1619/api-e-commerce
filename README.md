# Datos Interesanates a tener en cuenta sobre la API

1.- Crear una carpeta en su local y clonar el proyecto:
git clone https://github.com/fgala1619/api-e-commerce.git

2.- Una vez descargado tienen que tener en cuenta las herramientas necesarias para correr el proyecto:
- Descargar Composer: instala los paquetes y dependencias de laravel. Pueden descargarlo de la url oficial de esta herramienta:
https://getcomposer.org/
- IDE de desarrollo para abrir el proyecto, puede ser Visual Studio Code, PHP Storm, SublimeText, etc. (El que mas deseen).
- Entorno de desarrollo web: Laragon, Xampp ( instala PHP, Apache, MySQL entre otras como herramientas fundamentales). En mi caso particular use Laragon, pueden usar otro, no hay problemas en eso.
- MySQL/MariaDB para base de datos (en mi caso use MariaDB para mi es eficiente para la parte de backend)
- Un visor de base de datos.
- Postman.

3.- Cuando ya esten las herramientas necesarias, abrir el proyecto con el IDE de desarrollo y en la terminal que traen la mayoria de los entornos de desarrollo correr esta linea de comando:
composer install  (para instalar paquetes y dependencias que use en el desarrollo de la API)

4.- Una vez que instalen las dependencias, configurar el archivo ".env" del proyecto que es donde van a poner el nombre de la base de datos que se va a trabajar: conectar la bd (en mi caso trabaje con MySQL). Este archivo ".env" lo enviare por correo para que lo descarguen y lo copien en la carpeta raiz del proyecto y poder hacer estas configuraciones.

5.- Abrir su visor de base de datos y crear una base de datos que inicialmente no va a tener nada (este mismo nombre que le pongan a la base de datos es el mismo que tienen que poner en el archivo ".env" del proyecto para que no haya error de conexion).

6.- Ir al proyecto y en el terminal del IDE correr las migraciones para que esta base de datos tenga las tablas con la que se va a trabajar en la prueba de este proyecto. El comando es el siguiente:
php artisan migrate

7.- Despues de todo esto el proyecto esta listo para usarlo, para poder hacer las pruebas en postman, tienen que correr el servidor para poder hacer las peticiones. El comando es:
php artisan serve

Nota: en la bd hay campos que los tome como que pueden ser nulos y otros importantes, eso no quiere decir que todos sean importantes, pero creo que para un mejor entendimiento era necesario.



 
