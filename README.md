Custom Head Injector (MOJP 4.0)
===============================

Este es un módulo genérico desarrollado por Oscar R. Gómez para la distribución MOJP 4.0 y compatible con OJS 3.5.0.5 o superior que permite a los administradores de la revista inyectar bloque de código HTML personalizado directamente en el elemento `<head>` de todas las páginas de la plataforma.

Características
---------------
- Inyección de metadatos personalizados (`<meta>`).
- Soporte completo para bloques JSON-LD (Schema.org / ResearchOrganization / OpenGraph).
- Inclusión de hojas de estilo CSS adicionales, favicons y enlaces institucionales (`<link>`).
- Inserción de scripts de verificación, métricas o analíticas sin depender del pie de página.
- Área de texto plano en administración para evitar escapes accidentales o recortes de código.

Instalación
-----------
1. Descargar el .zip de instalación.
2. Subirlo a plugin/generic y descomprimirlo
3. Ubicar esta carpeta en `plugins/generic/customHeadInjector` y borrar el archivo comprimido
4. En el archivo lib/pkp/templates/frontend/components/headerHead.tpl ingrese el siguiente fragmento de código donde desea que aparezcan sus metadatos adicionales personalizados: 
{if $customHeadInjectorCode}
{$customHeadInjectorCode nofilter}
{/if}
***Si lo prefiere puede reemplazar ese archivo por el archivo de muestra headerHead.tplEJEMPLO que esta dentro del plugin***

5. Habilitar el plugin desde la sección de **Ajustes > Módulos > Módulos Genéricos** en el panel de administración de MOJP4.0 o de OJS 3.5.
6. Entrar a las **Opciones** del módulo y agregar el código deseado en el cuadro de texto.

📌 **NOTA DE INSTALACIÓN:**
 **Si descargas el archivo `.zip`** desde la portada del repositorio, al descomprimirlo dentro de `plugins/generic/` asegúrate de que la carpeta se llame exactamente **customHeadInjector** (quitando el sufijo `-main` que le agrega GitHub).
Si quieres instalarlo desde la administración de OJS usando el botón *"Cargar un nuevo módulo"*, descarga directamente el paquete oficial **`customHeadInjector.tar.gz`** desde la sección [Releases v4.0.0](https://github.com/menteclara-project/customHeadInjector/releases/latest).

Licencia
--------
Distribuido bajo la licencia GNU General Public License v3 (GPLv3).
