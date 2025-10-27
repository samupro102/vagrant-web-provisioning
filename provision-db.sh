#!/usr/bin/env bash
# Script de aprovisionamiento para PostgreSQL

# Actualiza los repositorios
sudo apt update -y

# Instala PostgreSQL
sudo apt install -y postgresql postgresql-contrib

# Inicia y habilita el servicio
sudo systemctl enable postgresql
sudo systemctl start postgresql

# Crea base de datos y usuario de ejemplo
sudo -u postgres psql -c "CREATE DATABASE ejemplo_db;"
sudo -u postgres psql -c "CREATE USER samuel WITH ENCRYPTED PASSWORD '1234';"
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE ejemplo_db TO samuel;"
