# 🌐 Proyecto Vagrant Web + DB

Este proyecto crea un entorno virtualizado con **Vagrant** que levanta dos máquinas virtuales en Ubuntu 20.04:
una para **servicios web (Apache + PHP)** y otra para **base de datos (PostgreSQL)**.

Permite desplegar una página web con contenido dinámico conectado a una base de datos.

---

## ⚙️ Estructura del proyecto

```
vagrant-web-provisioning/
│
├── Vagrantfile
├── provision-web.sh
├── provision-db.sh
├── index.html
├── info.php
└── www/
```

---

## 🚀 Pasos de instalación

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/samupro102/vagrant-web-provisioning.git
cd vagrant-web-provisioning
```

### 2️⃣ Revisar el Vagrantfile

El archivo **Vagrantfile** define dos máquinas virtuales:

* **web:** Servidor Apache + PHP
  IP privada → `192.168.56.10`
* **db:** Servidor PostgreSQL
  IP privada → `192.168.56.11`

---

### 3️⃣ Levantar la máquina web

```bash
vagrant up web
```

Este comando:

* Descarga la box `ubuntu/focal64`
* Instala Apache y PHP mediante el script `provision-web.sh`

Verifica los servicios:

```bash
vagrant ssh web
apache2 -v
php -v
```

---

### 4️⃣ Levantar la máquina de base de datos

```bash
vagrant up db
```

El script `provision-db.sh` instala PostgreSQL y crea una base de datos con usuario propio.

Dentro de la máquina:

```bash
vagrant ssh db
sudo -u postgres psql
\l        # Lista las bases de datos
\dt       # Muestra las tablas
```

---

### 5️⃣ Probar la aplicación web

En el navegador del host, accede a:

* **Página HTML:**

  ```
  http://192.168.56.10
  ```
* **Página PHP:**

  ```
  http://192.168.56.10/info.php
  ```

Si todo está correcto, verás información de PHP y/o los datos de la tabla `usuarios`.

---

## 🧩 Scripts utilizados

### 🖥️ provision-web.sh

```bash
#!/bin/bash
sudo apt update -y
sudo apt install -y apache2 php libapache2-mod-php
sudo systemctl enable apache2
sudo systemctl start apache2
```

🔹 Instala Apache y PHP
🔹 Configura `/var/www/html` como carpeta principal
🔹 Inicia y habilita el servicio web

---

### 🗄️ provision-db.sh

```bash
#!/bin/bash
sudo apt update -y
sudo apt install -y postgresql postgresql-contrib
sudo systemctl enable postgresql
sudo systemctl start postgresql

sudo -u postgres psql -c "CREATE DATABASE ejemplo_db;"
sudo -u postgres psql -c "CREATE USER samuel WITH PASSWORD '1234';"
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE ejemplo_db TO samuel;"
```

🔹 Instala y configura PostgreSQL
🔹 Crea la base de datos `ejemplo_db`
🔹 Crea el usuario `samuel` con contraseña `1234` y permisos completos

---

## 💻 Archivos del sitio

### index.html

Página de bienvenida:

```html
<!DOCTYPE html>
<html>
<head>
  <title>Bienvenido al sitio de Samuel</title>
</head>
<body>
  <h1>¡Hola! Bienvenido a mi sitio web con Vagrant</h1>
  <p>Proyecto de Sistemas Operativos - Samuel</p>
</body>
</html>
```

---

### info.php

Script PHP que muestra información del servidor o los datos de la base:

```php
<?php
$conexion = pg_connect("host=192.168.56.11 dbname=ejemplo_db user=samuel password=1234");
if (!$conexion) {
    echo "Error al conectar con la base de datos.";
} else {
    $resultado = pg_query($conexion, "SELECT * FROM usuarios;");
    echo "<h2>Usuarios registrados:</h2>";
    echo "<ul>";
    while ($fila = pg_fetch_assoc($resultado)) {
        echo "<li>" . $fila['nombre'] . " - " . $fila['correo'] . "</li>";
    }
    echo "</ul>";
}
?>
```

---

## 📸 Capturas de pantalla

Incluye en tu repositorio:

* `index.html` visible desde el navegador
* `info.php` mostrando los datos de la tabla `usuarios`
* Comprobación de PostgreSQL en la máquina `db`

---

## 🧾 Créditos

**Autor:** Samuel
**Curso:** Sistemas Operativos
**Año:** 2025
**Repositorio:** [samupro102/vagrant-web-provisioning](https://github.com/samupro102/vagrant-web-provisioning)
Evidencias
 Página principal (index.html)    ![Index](imagenes/index.png) 
 Info PHP (info.php)              ![Info](imagenes/info.png)   
 Datos desde PostgreSQL (usuarios.php)  ![Usuarios](imagenes/usarios.png)
