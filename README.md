<div id="header" align="center">
  <img src="https://github.com/Leticia-GA/psychotest-assistant/blob/master/assets/images/logoDark.png" width="400"/>
</div>

## Presentación del proyecto
El principal objetivo de este trabajo es la construcción de una página web de corrección de test psicológicos para una clínica imaginaria, cuyo funcionamiento habitual consiste en impartir consultas de forma presencial. 

La aplicación contará con tres tipos de usuarios: 
1. Psicólogos
2. Pacientes
3. Un administrador

La idea fundamental del proyecto es la realización de una página web en la que cada psicólogo pueda asignar uno o varios test a sus respectivos pacientes para que éstos los realicen donde y cuando quieran. Una vez el paciente haya realizado el o los test que se le hayan asignado, el psicólogo tendrá acceso a los datos de estos test ya corregidos de forma automática por la aplicación, de manera que pueda ver toda la información que aporten de una forma más organizada y rápida.

Tal y como está planteada la aplicación es posible añadir nuevos test, eliminarlos o editarlos.

## Principales funcionalidades

### _Psicólogos_
Algunas de las funcionalidades a las que tendrán acceso los usuarios con rol de psicólogo son las siguientes:
* Dar de alta/baja o modificar los datos de sus respectivos pacientes. Al realizar las altas también serán los encargados de introducir los datos personales e historial médico de cada paciente.
* Acceso a una interfaz en la que se muestre toda esta información sobre sus correspondientes pacientes.
* Acceso a un banco de test.
* Cada psicólogo podrá asignar uno o varios test de los disponibles en la aplicación a sus propios pacientes, para que éstos los realicen.
* Cuando un paciente realice un test que tenía asignado, el psicólogo recibirá una notificación dentro de la aplicación para poder ver los resultados.
* Dentro del área de cada paciente, el psicólogo podrá ver el histórico de test realizados por ese paciente, junto con la corrección y sus resultados. 

### _Pacientes_
Cada paciente tendrá acceso a una interfaz informativa en la que se muestren los siguientes datos:
* Nombre, email de contacto y titulación del psicólogo al que está asignado.
* Test pendiente/s de realizar (asignado/s por su psicólogo).
* Cuando un paciente tenga pendiente un test por cumplimentar, aparecerá una notificación interna en la aplicación a través de la cual podrá acceder a la realización de dicho test.

### _Administrador_
* El usuario con rol de administrador es único (podría corresponderse con el director de la clínica).
* Será el encargado de gestionar las altas, bajas y modificación de datos de los psicólogos. Para registrar un psicólogo deberá introducir una serie de datos personales (nombre, apellidos, email, etc.) así como profesionales (estudios universitarios, número de colegiación, habilitación o registro sanitario, etc.).
* El administrador cuenta con una interfaz en la que pueda acceder a los datos de todos los psicólogos. Además, en la sección de cada psicólogo podrá acceder también a los datos de los pacientes que tiene asignados (datos personales, datos médicos, test realizados, etc.).


***

## Instalación

**Paso 1:** Descargar/copiar el repositorio en una carpeta local y configurar el servidor web o utilizar el servidor de Symfony para acceder a la aplicación (https://symfony.com/doc/current/setup/symfony_server.html).

**Paso 2:** Crear una base de datos que llamada `psychotest_assistant` y adaptar el fichero .env a la configuración del equipo en el que se esté ejecutando.

**Paso 3:** Descargar las dependencias PHP mediante el comando `composer install`

**Paso 4:** Ejecutar las migraciones con el comando `php bin/console doctrine:migrations:migrate`

**Paso 5:** Cargar las fixtures para tener un conjunto de datos de inicio con el comando `php bin/console doctrine:fixtures:load`

**Paso 6:** Descargar las dependencias JavaScript mediante el comando `yarn install` y compilar estilos y JavaScript con el comando `yarn build`
