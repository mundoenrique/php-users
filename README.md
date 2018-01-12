# Conexión Personas Online

Conexión Personas Online es un portal web orientado a proporcionar servicios para los usuarios finales de productos Tebca/Servitebca.


## Instalación

### Dependencias

- **Apache HTTPD 2.4** o superior
- **PHP 5.6 - 7.0**


### Configuración

La aplicación puede ser configurada por medio de alguna de las siguientes tecnologías:

#### Docker

Puede instalarse por medio de Docker de forma sencilla ejecutando los siguientes comandos desde el directorio raíz del proyecto:

```sh
$ docker build --no-cache -t site-conexionpersonas .
$ docker run --name site-conexionpersonas -e 'CI_ENV=development' -d site-conexionpersonas
```


#### Apache HTTPD

Para emplear Apache HTTPD como mecanismo de montaje, es necesario seguir estos pasos:

1. Realizar el montaje de la carpeta `build` en una ubicación que pueda servirse desde Apache HTTPD
2. Duplicar el directorio `development` ubicado en `build/application/config` y renombrar el nuevo directorio como `local`
4. Modificar en el archivo `config.php` contenido en dicho directorio las definiciones que correspondan a URL y paths, según la configuración que haya proporcionado a su HTTPD

**Importante:** el directorio `local` y todas las configuraciones contenidas en éste son ignoradas por Git, de tal manera que permanezcan intactas en el ambiente de trabajo de cada colaborador.


## Colaboración

Si deseas contribuir en el desarrollo y mejora de este producto, por favor considerar alguno de los siguientes medios:

- Publicar un bug o solicitud de mejora en [Issues](./issues/new)
- Hacer **Fork** del repositorio, empleando un branch funcional a través del cual son bienvenidos los pull requests con la solución de tu caso


## Licencia

© 2018 NovoPayment Inc. All rights reserved.
