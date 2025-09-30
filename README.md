<p align="center">
<a href="https://laravel.com" target="_blank">
    <img src="images/logo.png" width="200" alt="KDT Logo">
</a>
</p>

# KDT 🚀
![Laravel](https://img.shields.io/badge/Laravel-v12-red?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---
## 📋 Requisitos previos
- PHP 8.1+
- Composer 
- MySQL
- Node.js & npm

---
## ⚡ Instalación

1. Clonar el repositorio
2. Instalar dependencias PHP
   -  En la carpeta raiz del proyecto ejecutar: `composer install`
3. Configurar archivo .env
   - `cp .env.example .env`
   - Generar key: `php artisan key:generate`
   - Ingresar las credenciales de tu base de datos en el nuevo archivo **.env**.
4. Migrar BBDD y ejecutar seeders
   - En la raiz del proyecto ejecutar: `php artisan migrate:fresh --seed`
5. Levantar servidor
   - `php artisan serve`
6. Seguir los pasos para levanta el FrontEnd: https://github.com/MarranoLuna/KDT-Ionic 


---

