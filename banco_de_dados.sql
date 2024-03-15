-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS qrcode_db;

-- Seleciona o banco de dados
USE qrcode_db;

-- Cria a tabela para armazenar os QR codes
CREATE TABLE IF NOT EXISTS qrcodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    data TEXT NOT NULL,
    image_url TEXT NOT NULL
);

-- Cria a tabela de usuários (para futuras implementações)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insere um usuário de exemplo (não recomendado para produção)
INSERT INTO users (username, password) VALUES ('admin', 'admin');
