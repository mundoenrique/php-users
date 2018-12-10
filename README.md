# Conexión Personas Online

Conexión Personas Online es un portal web orientado a proporcionar servicios para los usuarios finales de productos Tebca/Servitebca.

## Instalación

### Dependencias

- **Apache HTTPD 2.4** o superior
- **PHP 7.0** solamente

### Variables de entorno

Este proyecto depende de la definición de distintas variables de entorno para su funcionamiento correcto y seguro. La siguiente lista refleja todas aquellas que pueden ser especificadas:

| Nombre             | Descripción                                  | Ejemplo                    |
| ------------------ | -------------------------------------------- | -------------------------- |
| `CI_ENV`           | Identificación de entorno.                   | `development`              |
| `BASE_URL`         | URL base de aplicación.                      | `http://localhost`         |
| `BASE_CDN_URL`     | URL de assets de aplicación.                 | `http://localhost/assets`  |
| `BASE_CDN_PATH`    | Directorio de los assets.                    | `/var/www/html/assets/`    |
| `WS_URL`           | URL de servicios web (WS).                   | `http://192.168.0.1:8080/` |
| `WS_KEY`           | Llave de cifrado para los WS.                | `P455w0rd`                 |
| `ENCRYPTION_KEY`   | Llave de cifrado para sesión.                | `n0v0p4ym3nt`              |
| `SESS_COOKIE_NAME` | _(opcional)_ Nombre base de sesión.          | `cpo_session`              |
| `SESS_EXPIRATION`  | _(opcional)_ Tiempo de expiración de sesión. | `300`                      |
| `SESS_SAVE_PATH`   | _(opcional)_ Directorio para las sesiones.   | `/var/www/sessions`        |
| `COOKIE_PREFIX`    | _(opcional)_ Prefijo de nombre de cookie.    | `cpo_`                     |
| `COOKIE_DOMAIN`    | _(opcional)_ Dominio específico de cookie.   | `localhost`                |
| `COOKIE_PATH`      | _(opcional)_ Ruta dependiente del cookie.    | `/`                        |
| `COOKIE_SECURE`    | _(opcional)_ Seguridad de cookie (HTTPS).    | `FALSE`                    |

### Configuración

La aplicación puede ser configurada por medio de alguna de las siguientes tecnologías:

#### Docker

Puede instalarse por medio de Docker de forma sencilla ejecutando los siguientes comandos desde el directorio raíz del proyecto:

```bash
$ docker build --no-cache -t site-conexionpersonas .
$ docker run \
    --name site-conexionpersonas \
    --restart unless-stopped \
    -e 'CI_ENV=development' \
    -e 'BASE_URL=http://localhost' \
    -e 'BASE_CDN_URL=http://localhost/assets/' \
    -e 'BASE_CDN_PATH=/var/www/html/assets/' \
    -e 'WS_URL=http://192.168.0.1:8080/' \
    -e 'WS_KEY=P455w0rd' \
    -e 'ENCRYPTION_KEY=n0v0p4ym3nt-D3V' \
    -e 'SESS_SAVE_PATH=/var/www/sessions/' \
    -p 80:80 \
    -d site-conexionpersonas
```

#### Apache HTTPD

Para emplear Apache HTTPD como mecanismo de montaje, es necesario seguir estos pasos:

1. Realizar el montaje de la carpeta `build` en una ubicación que pueda servirse desde Apache HTTPD
2. Modificar el archivo `.htaccess` contenido en dicho directorio para incorporar las variables de entorno necesarias, siguiendo el patrón:
  ```apache
  SetEnv CI_ENV development
  SetEnv BASE_URL http://localhost
  SetEnv BASE_CDN_URL http://localhost/assets/
  ```

Recuerda agregar todas las variables de entorno que necesites para hacer que tu instalación local funcione correctamente.

## Colaboración

Si deseas contribuir en el desarrollo y mejora de este producto, por favor considerar alguno de los siguientes medios:

- Publicar un bug o solicitud de mejora en [Issues](./issues/new)
- Hacer **Fork** del repositorio, empleando un branch funcional a través del cual son bienvenidos los pull requests con la solución de tu caso


## Licencia

© 2018 NovoPayment Inc. All rights reserved.
