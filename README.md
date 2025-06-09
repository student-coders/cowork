

````markdown
# 🏢 Projet Coworking

---

## 🚀 Installation locale avec Docker

### 1️⃣ Cloner le dépôt  
```bash
git clone https://github.com/student-coders/cowork.git
cd cowork
````

### 2️⃣ Copier le fichier `.env.example` en `.env`

```bash
cp .env.example .env
```

### 3️⃣ Modifier `.env`

🔧 Remplacer `your_password_here` par le mot de passe MySQL que tu souhaites utiliser.

### 4️⃣ Lancer les services Docker

```bash
docker-compose up -d
```

### 5️⃣ Importer la base de données

```bash
docker exec -i docker_mysql mysql -u root --password= -e "CREATE DATABASE IF NOT EXISTS coworking_space;"

cat dump.sql | docker exec -i docker_mysql mysql -u root --password= coworking_space

```

💡 Quand demandé, saisis le mot de passe MySQL configuré dans `.env`.

### 6️⃣ Accéder à l'application

🌐 Ouvre ton navigateur et va sur :

```
http://localhost:8082
```

### 7️⃣ (Optionnel) Accéder à phpMyAdmin

Pour gérer ta base via une interface graphique :

```
http://localhost:8080
```

Login : root
Mot de passe : celui dans `.env`

---

## 🛑 Arrêter les conteneurs Docker

```bash
docker-compose down
```

---

## 📁 Structure du projet

```
/
├── cooworking/            # Ton code PHP
├── database.sql           # Script SQL de la base
├── docker-compose.yml     # Configuration Docker
├── .env.example           # Exemple de fichier de config
└── README.md              # Ce fichier d'instructions
```

---

## ⚠️ Notes importantes

* Ne **jamais** versionner `.env` avec les vrais mots de passe (ajoute-le dans `.gitignore`).
* Modifier `.env` **localement** avant de lancer le projet.
* Assure-toi que Docker est bien installé et lancé sur ta machine.

---

et merci