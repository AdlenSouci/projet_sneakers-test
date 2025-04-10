# 👟 Projet Sneakers-Test (Laravel)

Bienvenue dans le projet **Sneakers-Test**, une application développée avec **Laravel**. Suivez les étapes ci-dessous pour installer, configurer et utiliser le projet correctement sur votre machine locale.

---

## 🧰 Prérequis

Avant de commencer, assurez-vous d’avoir les éléments suivants installés :

- [PHP >= 8.1](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js & NPM](https://nodejs.org/)
- [MySQL](https://www.mysql.com/) (ou MariaDB)
- [XAMPP](https://www.apachefriends.org/fr/index.html) ou un autre environnement local
- Un éditeur de code comme [VS Code](https://code.visualstudio.com/)

---

## 📦 Installation du projet

### 1️⃣ Cloner le dépôt Git

Dans un dossier vide, ouvrez VS Code et exécutez la commande suivante dans le terminal :

```bash
git clone https://github.com/AdlenSouci/projet_sneakers-test.git
```

### 2️⃣ Ouvrir le projet

Une fois le projet cloné, ouvrez-le dans VS Code :

```bash
cd projet_sneakers-test
```

---

## ⚙️ Configuration de l’environnement

### 3️⃣ Copier le fichier `.env`

Copiez le fichier `.env-exemple` et renommez-le `.env` :

```bash
cp .env-exemple .env
```

### 4️⃣ Générer la clé d'application

Générez la clé d’application Laravel (indispensable pour le chiffrement) :

```bash
php artisan key:generate
```

### 5️⃣ Configurer la base de données

Dans le fichier `.env`, renseignez les informations de votre base de données MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_base
DB_USERNAME=root
DB_PASSWORD=
```

> ⚠️ Assurez-vous que la base de données `nom_de_votre_base` existe dans MySQL.

---

## 📅 Installation des dépendances

### 6️⃣ Installer les dépendances PHP

```bash
composer install
```

### 7️⃣ Installer les dépendances front-end

```bash
npm install
npm run build
```

> 💡 `npm run build` compile les fichiers front-end pour améliorer la performance de l’application.

---

## 🧬 Migration & Seed de la base de données

### 8️⃣ Exécuter les migrations

```bash
php artisan migrate
```

### 9️⃣ Créer un administrateur dans le seeder

Avant d'exécuter le seed, ouvrez le fichier `database/seeders/AdminSeeder.php` et personnalisez l'utilisateur :

```php
User::create([
    'name' => 'Nom Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('motdepasse'),
    'is_admin' => true,
]);
```

### 🔟 Exécuter les seeders

```bash
php artisan db:seed
```

---

## 🚀 Lancer l’application

### 1️⃣ Démarrer les services Apache et MySQL via XAMPP.

### 2️⃣ Lancer le serveur Laravel

```bash
php artisan serve
```

### 3️⃣ Ouvrir l’application dans le navigateur

Par défaut, elle sera disponible à l'adresse :

```
http://127.0.0.1:8000
```

---

## ✅ C’est prêt !

🎉 Félicitations ! Votre application **Sneakers-Test** est maintenant installée et fonctionnelle vous pouvez consulter les articles et passer des commandes.

