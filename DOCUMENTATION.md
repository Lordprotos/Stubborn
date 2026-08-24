Architecture

Structure du projet

src/
├── Controller/
│   ├── HomeController.php          # Page d'accueil
│   ├── AuthController.php          # Inscription/Connexion
│   ├── ProductController.php       # Catalogue et fiche produit
│   ├── CartController.php          # Gestion du panier
│   ├── CheckoutController.php      # Paiement Stripe
│   └── AdminController.php         # Back-office admin
├── Entity/
│   ├── User.php                    # Utilisateurs
│   ├── Product.php                 # Produits
│   ├── Stock.php                   # Stock par taille
│   ├── Order.php                   # Commandes
│   └── OrderItem.php               # Articles de commande
├── Repository/
│   ├── UserRepository.php
│   ├── ProductRepository.php       # Requêtes produits
│   ├── StockRepository.php
│   ├── OrderRepository.php
│   └── OrderItemRepository.php
├── Form/
│   ├── UserType.php                # Formulaire utilisateur
│   ├── LoginType.php               # Formulaire connexion
│   └── ProductType.php             # Formulaire produit
├── Security/
│   └── AppAuthenticator.php        # Authentificateur personnalisé
├── Service/
│   └── StripeService.php           # Service Stripe
└── DataFixtures/
    ├── UserFixtures.php            # Données test utilisateurs
    └── ProductFixtures.php         # Données test produits

templates/
├── base.html.twig                  # Template de base
├── home/index.html.twig            # Page d'accueil
├── auth/login.html.twig            # Formulaire connexion
├── auth/register.html.twig         # Formulaire inscription
├── product/list.html.twig          # Liste produits
├── product/detail.html.twig        # Fiche produit
├── cart/index.html.twig            # Panier
├── checkout/index.html.twig        # Paiement
├── checkout/success.html.twig      # Confirmation
├── admin/index.html.twig           # Back-office
└── email/verification.html.twig    # Email vérification

public/assets/
├── logo/logo.png
└── images/products/
    ├── Blackbelt.jpeg
    ├── Bluebelt.jpeg
    ├── BlueCloud.jpeg
    ├── BornInUsa.jpeg
    ├── Grayback.jpeg
    ├── GreenSchool.jpeg
    ├── PinkLady.jpeg
    ├── Pokeball.jpeg
    ├── Snow.jpeg
    └── Street.jpeg

config/
├── packages/security.yaml          # Configuration sécurité
├── packages/doctrine.yaml          # Configuration Doctrine
└── routes.yaml                     # Configuration routes

tests/
├── CartServiceTest.php             # Tests panier
└── StripeServiceTest.php           # Tests Stripe

migrations/
└── Version20240101000000.php       # Migrations Doctrine



Fonctionnalités

1. Accueil (/)
Affichage des 3 produits featured
Présentation de la marque Stubborn
Navigation vers catalogue

2. Catalogue (/products)
Liste de tous les produits
Filtrage par prix (10-29€, 29-35€, 35-50€)
Image, nom, prix pour chaque produit
Grille responsive 3 colonnes

3. Fiche produit (/product/{id})
Image haute résolution
Nom et prix
Sélecteur de taille (XS, S, M, L, XL)
Bouton "Ajouter au panier"

4. Panier (/cart)
Liste des articles avec image, nom, quantité
Calcul automatique du total
Bouton "Retirer" pour chaque article
Bouton "Finaliser la commande"

5. Paiement (/checkout)
Formulaire de paiement Stripe
Résumé de commande
Validation du paiement
Confirmation avec email

6. Back-office Admin (/admin)
Accessible uniquement avec ROLE_ADMIN
Liste des produits
Ajouter un produit
Modifier un produit
Supprimer un produit
Gérer le stock par taille



Authentification


Inscription (/register)

1.Cliquez sur "S'inscrire"
2.Remplissez le formulaire (email, nom, mot de passe)
3.Email de vérification envoyé automatiquement
4.Cliquez le lien pour activer votre compte
5.Vous pouvez maintenant vous connecter


Connexion (/login)

1.Cliquez sur "Se connecter"
2.Entrez votre email et mot de passe
3.Redirection vers l'accueil
4.Accès au catalogue, panier et checkout


Sécurité

-Mots de passe hashés avec bcrypt
-Bundle Security de Symfony
-CSRF protection sur tous les formulaires
-Authentificateur personnalisé (AppAuthenticator)
-Rôles: ROLE_ADMIN, ROLE_USER
-Access control par route



Gestion des produits

Back-office Admin
Accessible uniquement avec le rôle ROLE_ADMIN


Ajouter un produit:

1.Allez sur /admin
2.Remplissez le formulaire (nom, prix, image, description)
3.Sélectionnez les tailles et quantités
4.Cliquez "Ajouter"
5.Modifier un produit:

1.Allez sur /admin
2.Cliquez "Modifier" sur le produit
3.Modifiez les informations
4.Cliquez "Enregistrer"
5.Supprimer un produit:

1.Allez sur /admin
2.Cliquez "Supprimer" sur le produit
3.Confirmez la suppression


Gérer le stock:

-Stock par taille: XS, S, M, L, XL
-Chaque taille a une quantité indépendante
-Mis à jour lors de chaque achat



Paiement Stripe

Mode TEST
Carte de test valide:

Numéro: 4242 4242 4242 4242
Expiration: 12/26 (ou toute date future)
CVC: 123


Flux de paiement

1.Ajouter produits au panier
2.Sélectionner taille et quantité
3.Aller à la page panier
4.Cliquer "Finaliser la commande"
5.Remplir formulaire Stripe
6.Entrer informations carte
7.Paiement réussi
8.Confirmation et email
Sécurité


Clés Stripe en variables d'environnement

-Token créé côté client
-Charge créée côté serveur
-Email de confirmation envoyé
-Panier vidé après paiement réussi



Tests

Lancer les tests

php bin/phpunit tests/


Tests disponibles


CartServiceTest.php:

Test ajout produit au panier
Test calcul du total du panier
Test suppression du panier


StripeServiceTest.php:

Test validation montant Stripe
Test validation carte test
Test statut de paiement réussi

Résultats attendus

OK (6 tests, 6 assertions)

✅ Test ajout produit au panier: PASSÉ
✅ Test calcul total: PASSÉ (Total: 94.30 €)
✅ Test suppression du panier: PASSÉ
✅ Test montant Stripe: PASSÉ (29.90 EUR)
✅ Test carte Stripe: PASSÉ (4242 4242 4242 4242)
✅ Test paiement Stripe: PASSÉ (Status: succeeded)



Comptes de test


Administrateur

Email: admin@stubborn.com
Mot de passe: admin123
Rôle: ROLE_ADMIN
Accès: /admin (back-office)


Utilisateur standard
Email: test@example.com
Mot de passe: test123
Rôle: ROLE_USER
Accès: Catalogue, panier, paiement



Endpoints
Route	                Méthode	    Auth	  Description

/	                    GET	        ❌	    Accueil
/register	            GET/POST	❌	    Inscription
/login	                GET/POST	❌	    Connexion
/logout	                GET	        ✅	    Déconnexion
/products	            GET	        ✅	    Liste produits
/product/{id}	        GET	        ✅	    Détail produit
/cart	                GET	        ✅	    Panier
/cart/add/{id}	        POST	    ✅	    Ajouter au panier
/cart/remove/{key}	    POST	    ✅	    Retirer du panier
/checkout	            GET	        ✅	    Page paiement
/checkout/process	    POST	    ✅	    Traiter paiement
/admin	                GET	        ✅ADMIN	Back-office
/admin/edit/{id}	    GET/POST	✅ADMIN	Modifier produit
/admin/delete/{id}	    POST	    ✅ADMIN	Supprimer produit



Configuration

Variables d'environnement (.env.local)

APP_ENV=dev
APP_SECRET=your_secret_key_here_change_in_production
APP_URL=http://localhost:8000

DATABASE_URL="mysql://root:@127.0.0.1:3306/stubborn_ecommerce?serverVersion=8.0&charset=utf8mb4"

MAILER_DSN=smtp://localhost:1025




Dépannage


Erreur: Base de données introuvable

php bin/console doctrine:database:create
php bin/console doctrine:schema:create


Erreur: Templates not found

php bin/console cache:clear


Erreur: Stripe error

Vérifier les clés dans .env.local
Vérifier que composer require stripe/stripe-php est installé


MySQL ne démarre pas

Démarrer XAMPP/WAMP MySQL
Ou: net start MySQL80


Erreur: Migration failed

Les tables existent déjà
Exécutez: php bin/console doctrine:migrations:version DoctrineMigrations\Version20240101000000 --add
Support
Email: stubborn@blabla.com Adresse: Piccadilly Circus, London W1J 0DA, Royaume-Uni Slogan: Don't compromise on your look

Licence
Propriétaire - Tous droits réservés 2024

