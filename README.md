
# 👟 Projet Sneakers-Test (Laravel)

Bienvenue dans le projet **Sneakers-Test**, une application développée avec **Laravel**. Suivez les étapes ci-dessous pour installer, configurer et utiliser le projet correctement sur votre machine locale.

---

## 🧰 Prérequis

Avant de commencer, assurez-vous d’avoir les éléments suivants installés :

- Laravel
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
🔑 **Important :** Voici un message important !
le seeders admin est très important il permet d'etre utiliser dans l'application lourde qui est lié au site web, pour utiliser l'application lourde utlise se compte administrateur uniquement sans compte administrateur on ne pourra pas l'utiliser et integrer de nouvelles paires de sneakers ou de nouvelles marque

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

## 📧 Configuration des e-mails

Pour permettre l’envoi des notifications par e-mail (ex : lorsqu’un client passe une commande), vous devez effectuer deux choses :

### 2.1 Configuration des paramètres dans `.env`

Dans le fichier `.env`, renseignez les informations liées à votre fournisseur de messagerie (exemple avec Gmail) :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=**votre.email@gmail.com**
MAIL_PASSWORD="votre_mot_de_passe_application"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=**votre.email@gmail.com**
MAIL_FROM_NAME="${APP_NAME}"
```

> ⚠️ Le `MAIL_PASSWORD` est un **mot de passe d’application**, à générer depuis votre compte Google (et non votre mot de passe principal).  https://support.google.com/accounts/answer/185833?hl=fr

### 2.2 Pour les autres services (SMTP)
Voici les hôtes et ports SMTP courants pour d'autres services de messagerie :

Service	MAIL_HOST	MAIL_PORT	MAIL_ENCRYPTION
Gmail	smtp.gmail.com	587	tls
Outlook	smtp.office365.com	587	tls
Yahoo	smtp.mail.yahoo.com	587	tls
iCloud	smtp.mail.me.com	587	tls
Zoho Mail	smtp.zoho.com	587	tls

### 2️.3 Mise à jour dans `BasketController.php` (ligne 291 à 294)

Dans le fichier `app/Http/Controllers/BasketController.php`, à partir de la **ligne 291**, modifiez l’adresse e-mail pour qu’elle corresponde à **votre propre adresse** de réception :

```php
Mail::raw($message, function ($message) {
    $message->to('votreadressemail@mail.com') // Remplacer par votre adresse e-mail
        ->subject('Nouvelle Commande sur votre site');
});
```

🛠️ **Remplacez** l’adresse `votreadressemail@mail.com` par l’adresse à laquelle vous souhaitez recevoir les notifications de nouvelles commandes.

---

### 2.4 Mise à jour dans `ContactController.php` (ligne 32 à 36)

```php
  try {
            Mail::send('emails.contact', $details, function ($message) use ($details) {
                $message->to('votreadressemail@mail.com')
                    ->subject('Contact Form Message');
            });

            // Retourne une réponse JSON avec success:true
            return response()->json(['success' => true, 'message' => 'Email sent successfully!']);
        } catch (\Exception $e) {
            // En cas d'échec, retourne une réponse JSON avec success:false
            return response()->json(['success' => false, 'message' => 'Email sending failed: ' . $e->getMessage()], 500);
        }
```

🛠️ **Remplacez** l’adresse `votreadressemail@mail.com` par l’adresse à laquelle vous souhaitez recevoir les notifications.

---
### 2.5 Mise à jour dans `mailController.php` (ligne 13 à 18)

```php
  public function contact(Request $request)
    {
        $data = $request->all();
        Mail::to('votreadressemail@mail.com')->send(new ContactMail($data));
        return response()->json(['message' => 'Votre message a bien été envoyé.']);
    }
```

🛠️ **Remplacez** l’adresse `votreadressemail@mail.com` par l’adresse à laquelle vous souhaitez recevoir les notifications.

---

### 2.6 Mise à jour dans `\config\mail.php` (ligne 13 à 18)
```php
//ligne 28 a 37
  'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'),  // Utilise Outlook SMTP host
            'port' => env('MAIL_PORT', 587),                   // Port pour Outlook
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),     // Utilisation de l'encryption TLS
            'username' => env('MAIL_USERNAME'),                // Ton adresse e-mail Outlook
            'password' => env('MAIL_PASSWORD'),                // Le mot de passe ou mot de passe d'application
            'timeout' => null,
            'auth_mode' => null,
```

🛠️ **Remplacez** le smtp correspondant a celui utiliser par votre adresse mail.

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

🎉 Félicitations ! Votre application **Sneakers-Test** est maintenant installée et fonctionnelle. Vous pouvez consulter les articles et passer des commandes  ( factice ).


# piste d'amelioration du projet

## basket.blade.php
Changement de la pointure dans le panier

## mail
confirmation de mail pour l'admin devrait plutot etre une vue blade comme pour la vue confirmation adresser au client.

## remise 
faire des remises pour des utilisateurs ayant deja passer commande.














