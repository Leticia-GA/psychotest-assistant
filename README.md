# INSTALACIÓN

**Paso 1:** Descargar/copiar el repositorio en una carpeta local y configurar el servidor web o utilizar el servidor de Symfony para acceder a la aplicación (https://symfony.com/doc/current/setup/symfony_server.html).

**Paso 2:** Crear una base de datos que llamada `psychotest_assistant` y adaptar el fichero .env a la configuración del equipo en el que se esté ejecutando.

**Paso 3:** Descargar las dependencias PHP mediante el comando `composer install`

**Paso 4:** Ejecutar las migraciones con el comando `php bin/console doctrine:migrations:migrate`

**Paso 5:** Cargar las fixtures para tener un conjunto de datos de inicio con el comando `php bin/console doctrine:fixtures:load`

**Paso 6:** Descargar las dependencias JavaScript mediante el comando `yarn install` y compilar estilos y JavaScript con el comando `yarn build`