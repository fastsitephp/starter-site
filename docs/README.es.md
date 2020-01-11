# 🌟 Sitio de inicio de FastSitePHP

**¡Gracias por su visita!** 🌠👍

**Este es el sitio de inicio principal para FastSitePHP.** Incluye varias páginas de ejemplos y proporciona una estructura básica de directorio / archivo. El sitio está diseñado para proporcionar una estructura para el contenido básico (JavaScript, CSS, etc.) sin dejar de ser pequeño para que sea fácil eliminar los archivos que no necesita y personalizarlos para su sitio.

## :rocket: Empezando

**Comenzar a usar PHP y FastSitePHP es extremadamente fácil.** Si no tiene PHP instalado, consulte las instrucciones para Windows, Mac y Linux en la página de inicio:

https://www.fastsitephp.com/es/getting-started

El sitio de inicio no incluye el Framework, por lo que deberá ejecutar `scripts/install.php` para descargarlo e instalarlo. Una vez configurado, puede iniciar un sitio desde la línea de comandos como se muestra a continuación o si utiliza un editor de código o IDE [Visual Studio Code, GitHub Atom, etc.], puede iniciar el sitio directamente desde su editor. Consulte la página de inicio anterior para obtener más información.

### Descargue y ejecute este sitio

~~~text
# Descargue este repositorio
cd {starter-site-root}
php ./scripts/install.php
php -S localhost:3000
~~~

### Cree un nuevo proyecto usando Composer (PHP Dependency / Package Manager)

Además de descargar este repositorio, también puede iniciar un nuevo proyecto con Composer.

~~~text
composer create-project fastsitephp/starter-site my-app
cd my-app
php -S localhost:3000
~~~

### Instalar directamente en un servidor

Un script bash está disponible para una configuración rápida de un servidor web (Apache o nginx), PHP y FastSitePHP con un sitio de inicio. Este script funciona para una configuración completa en un sistema operativo predeterminado cuando no hay nada instalado.

Sistemas operativos compatibles (se agregarán más en el futuro):

* Ubuntu 18.04 LTS

~~~bash
wget https://www.fastsitephp.com/downloads/create-fast-site.sh
sudo bash create-fast-site.sh
~~~

### Versiones compatibles de PHP

* El sitio FastSitePHP Stater funciona con todas las versiones de PHP desde `5.4` a` 7.4`.
* FastSitePHP Framework también es compatible con PHP 5.3.
* Si necesita instalar el sitio Stater en un servidor con PHP 5.3, deberá realizar algunos cambios menores, como reemplazar `[]` por `array ()` y evitar el uso de etiquetas PHP Short en las plantillas.

### Directory Structure

```text
{root}
|
|   # Código PHP
├── app
|   ├── Controllers/*.php
|   ├── Middleware/*.php
|   ├── Models/*.php
|   ├── Views/*.php
│   └── app.php       # Archivo de solicitud principal
│
|   # Archivos de datos de la aplicación
├── app_data
│   └── i18n/*.json   # Archivos JSON para múltiples idiomas
│
|   # Documentación
├── docs
│
|   # Carpeta raíz web
├── public
|   ├── css/*
|   ├── img/*
|   ├── js/*
│   └── index.php  # Punto de entrada para web root
│
|   # Scripts de aplicación
├── scripts
│
|   # Archivos de proveedor (creados al instalar dependencias)
└── vendor
```

## :desktop_computer: Pantallas de impresión del sitio de inicio (Capturas de pantalla)

![Página de inicio del sitio de inicio](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/home-page.png)

![Página de ejemplo del sitio de inicio](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/data-page.png)

![Página de inicio de sesión del sitio de inicio](https://raw.githubusercontent.com/fastsitephp/static-files/master/img/starter_site/2020-01-10/login-page.png)

## :handshake: Contribuyendo

* Si encuentra un error tipográfico o gramatical, corríjalo y envíelo.
* Si desea ayudar con las traducciones, envíe los archivos de idioma JSON en `app_data/i18n`.
* Si desea enviar cualquier otro cambio, abra primero un problema. Se pretende que este sea un sitio mínimo, por lo que agregar más código necesita una buena razón.

## :memo: Licencia

Este proyecto está licenciado bajo la Licencia MIT; consulte el archivo [LICENSE](../LICENSE) para obtener más información.
