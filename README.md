# 🌿 Plant Tracker API

API RESTful desarrollada con Laravel para el seguimiento y gestión de plantas personales. Esta API proporciona un backend robusto para la aplicación Plant Tracker, permitiendo a los usuarios gestionar su colección de plantas, registrar riegos, y mantener un seguimiento detallado del cuidado de sus plantas.

## ⚠️ Dependencias del Proyecto

Esta API es el backend del sistema Plant Tracker y es **requerida** por el frontend para funcionar. El frontend se encuentra en el repositorio [plant-tracker-app](https://github.com/RonaldRBB/plant-tracker-app).

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- MySQL/PostgreSQL
- Redis (opcional)
- Node.js y npm (para desarrollo)

### Configuración del Frontend
1. Clona y configura el repositorio del frontend:
   ```bash
   git clone git@github.com:RonaldRBB/plant-tracker-app.git
   cd plant-tracker-app
   npm install
   cp .env.example .env.local
   # Edita .env.local y configura NEXT_PUBLIC_API_BASE_URL
   npm run dev
   ```

2. Asegúrate de que la API esté accesible desde la URL configurada en el frontend

## 📋 Estructura del Proyecto

### Modelos Principales
- `Plant`: Modelo que representa el catálogo de plantas disponibles. Almacena información como nombre científico, nombre común, requisitos de luz, frecuencia de riego por estación, y clasificación taxonómica.
- `UserPlant`: Representa las plantas registradas por usuarios. Incluye información personalizada como apodo, ubicación, fecha de adquisición, y notas específicas.
- `WateringLog`: Registro detallado de cada riego realizado, incluyendo fecha, método de riego, uso de fertilizantes, y aplicaciones especiales como trichoderma.
- `TaxonomicClassification`: Sistema de clasificación taxonómica que organiza las plantas por reino, división, clase, orden y familia.
- `PlantImage`: Gestión de imágenes asociadas a las plantas, permitiendo múltiples imágenes por planta.

### Controladores
- `PlantsController`: Gestiona el catálogo completo de plantas, incluyendo operaciones CRUD y búsqueda avanzada.
- `UserPlantsController`: Maneja las plantas personales de los usuarios, incluyendo registro, actualización y eliminación.
- `WateringLogsController`: Controla el registro y seguimiento de riegos, con funcionalidades para registrar nuevos riegos y consultar historial.
- `TaxonomicClassificationController`: Administra la clasificación taxonómica de las plantas, permitiendo una organización científica.
- `PlantsImageController`: Gestiona la carga, actualización y eliminación de imágenes de plantas.

## 🚀 Características Principales

### Gestión de Plantas
- Catálogo completo de plantas con información detallada
- Búsqueda avanzada por nombre científico o común
- Clasificación taxonómica completa
- Gestión de imágenes múltiples por planta

### Plantas de Usuario
- Registro personalizado de plantas
- Seguimiento de ubicación y condiciones
- Historial de adquisición y estado
- Notas y observaciones personalizadas

### Sistema de Riego
- Registro detallado de cada riego
- Diferentes métodos de riego (superficial, inmersión, pulverización)
- Seguimiento de fertilización y tratamientos especiales
- Cálculo automático de próximos riegos

### Autenticación y Seguridad
- Sistema de autenticación JWT
- Protección de rutas y recursos
- Validación de datos de entrada
- Manejo de errores y excepciones

## 🛠️ Requisitos Técnicos

- PHP 8.2 o superior
- Composer para gestión de dependencias
- MySQL 5.7+ o PostgreSQL 10+
- Laravel 10.x
- Extensión PHP para MySQL/PostgreSQL
- Extensión PHP para cURL
- Extensión PHP para OpenSSL

## 📦 Instalación

1. **Clonar el repositorio**
   ```bash
   git clone git@github.com:RonaldRBB/plant-tracker-api.git
   cd plant-tracker-api
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor, sigue estos pasos:

1. Fork el proyecto
2. Crea una rama para tu característica (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

### Guías de Contribución
- Sigue las convenciones de código de Laravel
- Escribe pruebas para nuevas funcionalidades
- Actualiza la documentación según sea necesario
- Mantén el código limpio y bien documentado

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🔗 Enlaces Relacionados

- [Frontend App](https://github.com/RonaldRBB/plant-tracker-app)
