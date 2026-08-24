# Stubborn E-Commerce - Documentation

## 📋 Table des matières
1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Architecture](#architecture)
4. [Guide d'utilisation](#guide-dutilisation)
5. [API](#api)

## Introduction

Stubborn est une boutique en ligne de sweat-shirts développée avec Symfony 7 et MySQL.

**Site :** Piccadilly Circus, London W1J 0DA, Royaume-Uni  
**Email :** stubborn@blabla.com  
**Slogan :** Don't compromise on your look

## Installation

### Prérequis
- PHP 8.2+
- MySQL 8.0+
- Composer
- Symfony CLI

### Étapes

1. Cloner le projet
```bash
git clone <votre-repo>
cd stubborn-ecommerce
```

2. Installer les dépendances
```bash
composer install
```

3. Configurer la base de données
```bash
cp .env .env.local
# Modifier DATABASE_URL dans .env.local
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

4. Charger les fixtures
```bash
php bin/console doctrine:fixtures:load
```

5. Démarrer le serveur
```bash
symfony serve
```

## Architecture

### Structure du projet

