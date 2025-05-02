README - Sistema de Gestión de Tareas Internas
Banner del Proyecto

📌 Descripción del Proyecto
Sistema web interno para la gestión de tareas entre departamentos (Finanzas, Administración e Informática), desarrollado con metodología FDD (Feature Driven Development).

🚀 Características Principales
Autenticación segura por roles (usuario, informático, administrador).

Solicitud de tareas con prioridades (alta, media, baja).

Dashboards diferenciados según el rol del usuario.

Historial de tareas completadas.

🛠 Tecnologías Utilizadas
Tecnología	Uso
PHP 	Lógica del backend
MySQL	Base de datos relacional
Bootstrap 5	Diseño responsive

⚙️ Requisitos del Sistema
Servidor
Apache 2.4+ o Nginx

PHP 8.0+ con extensiones: pdo_mysql, mbstring

MySQL 5.7+ o MariaDB

Cliente
Navegador moderno (Chrome, Firefox, Edge)

📦 Instalación
1. Clonar el Repositorio
bash
git clone https://github.com/tu-usuario/gestion-tareas.git
cd gestion-tareas
2. Configurar la Base de Datos
Importar el esquema SQL:

bash
mysql -u usuario -p nombre_bd < database/schema.sql
3. Configurar Variables de Entorno
Crear un archivo .env basado en .env.example:

ini
DB_HOST=localhost
DB_NAME=nombre_bd
DB_USER=usuario
DB_PASS=contraseña
SECRET_KEY=clave_recaptcha
4. Iniciar el Servidor
bash
php -S localhost:8000 -t public/

USUARIO ADMINISTRADOR
```
 user: danyelcm2@gmail.com
contrasena: 123
```
