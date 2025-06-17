
---

## 📥 Exportación de datos

- 📄 PDF: informes con logo, evaluador, resultados, lugar, firma digital
- 📊 Excel: reportes filtrables por atleta, test, evaluador o lugar

---

## 🔐 Seguridad

- Autenticación segura con sesiones PHP
- Contraseñas encriptadas con `password_hash()`
- Validaciones backend/frontend
- Roles separados (ACL)
- Logs y control de accesos opcionales

---

## ⚙️ Requisitos del sistema

- PHP >= 8.1
- MySQL 5.7+
- Apache o Nginx
- Composer
- Librerías:
  - `dompdf` (PDF)
  - `PhpSpreadsheet` (Excel)

---

## 🧑‍💻 Desarrollado por

Sistema diseñado por **Gustavo**, Analista Programador  
Pensado para instituciones deportivas, organismos públicos y proyectos de desarrollo físico y captación de talentos.

---
├── public/
│   ├── index.php                  # Punto de entrada principal del sistema, carga inicial del enrutador y sesión
│   └── assets/
│       ├── css/
│       │   └── styles.css         # Estilos generales para toda la interfaz
│       ├── js/
│       │   └── scripts.js         # Scripts generales del sistema (navbar, validaciones, etc.)
│       └── images/                # Logos institucionales, íconos, etc.

├── app/
│   ├── controllers/
│   │   ├── AuthController.php     # Controlador para login, logout, y registro
│   │   ├── DashboardController.php # Controla la vista y datos del panel principal según el rol
│   │   ├── AtletaController.php   # Gestión de atletas (crear, editar, listar, historial)
│   │   ├── EvaluadorController.php # Gestión de evaluadores (solo por admin)
│   │   ├── AdminController.php    # Funciones exclusivas del administrador (usuarios, estadísticas)
│   │   └── TestController.php     # Asignación, carga y visualización de resultados de tests
│   
│   ├── models/
│   │   ├── Usuario.php            # Entidad para login, contraseña, rol
│   │   ├── Atleta.php             # Datos personales y físicos del atleta
│   │   ├── Evaluador.php          # Información de los evaluadores
│   │   ├── Lugar.php              # Zonas, centros, direcciones
│   │   ├── Test.php               # Catálogo de tipos de pruebas físicas
│   │   └── ResultadoTest.php      # Resultados detallados por atleta, test y fecha
│
│   ├── views/
│   │   ├── auth/
│   │   │   ├── login.php          # Formulario de inicio de sesión
│   │   │   └── register.php       # Registro de nuevos evaluadores (opcional)
│   │   ├── dashboard/
│   │   │   ├── admin.php          # Vista del panel de control para administradores
│   │   │   └── evaluador.php      # Vista del panel de control para evaluadores
│   │   ├── atletas/
│   │   │   ├── listado.php        # Listado general de atletas
│   │   │   ├── crear.php          # Formulario para alta de atletas
│   │   │   └── historial.php      # Visualización del historial de evaluaciones
│   │   ├── tests/
│   │   │   ├── asignar.php        # Formulario para asignar un test
│   │   │   ├── registrar.php      # Registro de resultados de un test
│   │   │   └── resultados.php     # Vista detallada de resultados
│   │   └── componentes/
│   │       ├── navbar.php         # Menú de navegación superior
│   │       └── footer.php         # Pie de página institucional
│
│   ├── core/
│   │   ├── Router.php             # Enrutador básico para cargar controladores
│   │   ├── Controller.php         # Clase base que todos los controladores extienden
│   │   └── View.php               # Sistema de renderizado de vistas
│
│   ├── utils/
│   │   ├── Auth.php               # Funciones para autenticación, sesión y roles
│   │   ├── PDFGenerator.php       # Generación de reportes en PDF
│   │   ├── ExcelExporter.php      # Exportación de datos en formato Excel
│   │   └── Validator.php          # Validaciones de datos comunes en formularios

├── config/
│   ├── database.php               # Conexión a MySQL usando PDO
│   └── config.php                 # Constantes generales como rutas, nombre del sistema

├── storage/
│   ├── logs/                      # Logs de errores o acciones del sistema
│   └── uploads/                   # Carpeta opcional para subir archivos si se requiere

├── vendor/                        # Librerías instaladas con Composer

├── .htaccess                      # Permite URLs limpias con Apache (rewrite)
├── .env                           # Variables de entorno: DB, entorno, clave secreta
├── Dockerfile                     # Contenedor PHP/Apache con extensiones instaladas
├── docker-compose.yml             # Orquestación de servicios: app, MySQL, phpMyAdmin
├── composer.json                  # Gestión de dependencias PHP
└── README.md                      # Documentación del sistema: uso, arquitectura, instalación# sistema_evaluacion
