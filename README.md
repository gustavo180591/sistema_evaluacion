
# Sistema de Evaluación Deportiva

Un sistema completo para la gestión de evaluaciones físicas y deportivas, diseñado para instituciones deportivas, organismos públicos y proyectos de desarrollo físico y captación de talentos.

## 🚀 Características Principales

- 🔍 Gestión completa de atletas y evaluadores
- 📊 Sistema de evaluaciones con múltiples tipos de tests
- 📈 Generación de estadísticas y reportes
- 📄 Exportación de datos en PDF y Excel
- 🔐 Sistema de seguridad robusto con roles y permisos
- 📱 Interfaz web moderna y responsive
- 🐳 Soporte nativo para Docker
- 🚽 Gestión de discapacidades para atletas adaptados
- 📇 Asignación de discapacidades en perfiles de atletas

## 📥 Exportación de datos

- 📄 PDF: Informes detallados con logo, evaluador, resultados, lugar y firma digital
- 📊 Excel: Reportes filtrables por atleta, test, evaluador o lugar
- 📈 Gráficos y estadísticas exportables

## 🔐 Seguridad

- 🔐 Autenticación segura con sesiones PHP
- 🔑 Contraseñas encriptadas con `password_hash()`
- ✅ Validaciones backend y frontend
- 👥 Roles separados (ACL)
- 📝 Logs y control de accesos opcionales
- 🔒 Protección contra inyecciones SQL
- 🛡️ Protección contra CSRF

## ⚙️ Requisitos del sistema

### Requisitos mínimos

- PHP >= 8.1
- MySQL 5.7+
- Apache o Nginx con mod_rewrite
- Composer
- PHP Extensions:
  - PDO
  - mbstring
  - dompdf
  - PhpSpreadsheet

### Dependencias PHP

```json
{
    "require": {
        "php": ">=8.1",
        "dompdf/dompdf": "^2.0",
        "phpoffice/phpspreadsheet": "^1.29"
    }
}
```

## 📦 Instalación

### Instalación Local

1. Clonar el repositorio:
```bash
git clone [URL_DEL_REPOSITORIO]
cd sistema_evaluacion
```

2. Instalar dependencias:
```bash
composer install
```

3. Configurar la base de datos:
```bash
cp .env.example .env
```

4. Crear la base de datos y ejecutar las migraciones:
```bash
php artisan migrate
```

5. Iniciar el servidor de desarrollo:
```bash
php -S localhost:8000 -t public
```

### Instalación con Docker

1. Construir y ejecutar los contenedores:
```bash
docker-compose up -d
```

2. Acceder a la aplicación:
```
http://localhost
```

## 🧑‍💻 Estructura del proyecto

```
├── public/                        # Archivos públicos
│   ├── index.php                  # Punto de entrada principal
│   └── assets/                    # Recursos estáticos
│       ├── css/                   # Estilos
│       ├── js/                    # Scripts
│       └── images/                # Imágenes

├── app/                          # Código fuente principal
│   ├── controllers/              # Controladores
│   │   ├── AuthController.php    # Autenticación
│   │   ├── DashboardController.php # Panel principal
│   │   ├── AtletaController.php  # Gestión de atletas
│   │   ├── EvaluadorController.php # Gestión de evaluadores
│   │   ├── AdminController.php   # Panel de administración
│   │   ├── TestController.php    # Gestión de tests
│   │   └── DiscapacidadController.php # Gestión de discapacidades
│   
│   ├── models/                   # Modelos de datos
│   │   ├── Usuario.php           # Usuarios y roles
│   │   ├── Atleta.php            # Información de atletas
│   │   ├── Evaluador.php         # Información de evaluadores
│   │   ├── Lugar.php             # Ubicaciones
│   │   ├── Test.php              # Tipos de pruebas
│   │   ├── ResultadoTest.php     # Resultados de evaluaciones
│   │   └── Discapacidad.php      # Gestión de discapacidades
│
│   ├── views/                    # Vistas
│   │   ├── auth/                 # Autenticación
│   │   ├── dashboard/            # Paneles
│   │   ├── atletas/              # Gestión de atletas
│   │   ├── tests/                # Gestión de tests
│   │   └── componentes/          # Componentes reutilizables
│
│   ├── core/                     # Núcleo del sistema
│   │   ├── Router.php            # Enrutamiento
│   │   ├── Controller.php        # Base de controladores
│   │   └── View.php              # Sistema de vistas
│
│   └── utils/                    # Utilidades
│       ├── Auth.php              # Autenticación
│       ├── PDFGenerator.php      # Generación de PDF
│       ├── ExcelExporter.php     # Exportación Excel
│       └── Validator.php         # Validaciones

├── config/                       # Configuración
│   ├── database.php              # Base de datos
│   └── config.php                # Configuración general

├── storage/                      # Archivos de almacenamiento
│   ├── logs/                     # Logs del sistema
│   └── uploads/                  # Archivos subidos

└── vendor/                       # Dependencias Composer
```

## 📝 Variables de entorno

Copiar el archivo `.env.example` a `.env` y modificar según sea necesario:

```env
APP_NAME="Sistema de Evaluación"
APP_ENV=local
APP_DEBUG=true

DB_HOST=localhost
DB_DATABASE=sistema_evaluacion
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=your-secret-key-here
```

## 🛠️ Uso

### Login

Acceder al sistema con las credenciales de administrador:

- Email: admin@example.com
- Password: password

### Roles

- **Administrador**: Acceso completo al sistema
- **Evaluador**: Gestión de evaluaciones y atletas
- **Usuario**: Visualización de resultados

## 📱 Uso con Docker

1. Construir y ejecutar los servicios:
```bash
docker-compose up -d
```

2. Acceder a la aplicación:
```
http://localhost
```

3. Acceder a phpMyAdmin:
```
http://localhost:8080
```

## 📝 Licencia

Este proyecto está bajo la licencia MIT.

## 🙏 Agradecimientos

- [PHP](https://php.net)
- [MySQL](https://mysql.com)
- [Composer](https://getcomposer.org)
- [DOMPDF](https://github.com/dompdf/dompdf)
- [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet)

## 📞 Contacto

Para soporte o consultas, contactar a:

- Gustavo [email@example.com]
