# 🐳 Guía Rápida: Desplegar con Docker

Esta guía explica cómo levantar el proyecto utilizando **Docker** y **Docker Compose** en unos sencillos pasos.

---

## 🚀 Requisitos Previos
- Tener instalado **Docker Desktop** (o Docker Engine + Docker Compose).

---

## ⚡ Pasos para levantar la aplicación

### 1. Preparar archivo de entorno (si no existe)
Si no tienes el archivo `.env`, puedes copiarlo desde `.env.example`:

```bash
cp .env.example .env
```

### 2. Construir e iniciar el contenedor
Ejecuta el siguiente comando en la terminal desde la raíz del proyecto:

```bash
docker compose up -d --build
```

### 3. Generar la clave de la aplicación y ejecutar migraciones
Ejecuta los siguientes dos comandos dentro del contenedor:

```bash
docker compose exec laravel php artisan key:generate
docker compose exec laravel php artisan migrate
```

---

### 4. Acceder a la aplicación
Abre tu navegador web e ingresa a:

👉 **[http://localhost:8000/books](http://localhost:8000/books)**

---

## 🛠️ Comandos útiles

| Acción | Comando |
| :--- | :--- |
| **Ver logs en tiempo real** | `docker compose logs -f` |
| **Detener la aplicación** | `docker compose down` |
| **Ejecutar comandos Artisan** | `docker compose exec laravel php artisan <comando>` |
| **Entrar a la consola del contenedor** | `docker compose exec laravel bash` |
| **Reiniciar base de datos y migraciones** | `docker compose exec laravel php artisan migrate:fresh` |

---

## 📌 Notas
- **Cambios en el código:** Los cambios en tus archivos locales se sincronizan inmediatamente en el contenedor.
- **Persistencia de datos:** Los datos guardados en la base de datos SQLite persistirán en tu carpeta local `database/database.sqlite`.
