# Shop

Ce code correspond à un Shop basé sur le FrameWork Laravel, suite d'une série d'articles [sur mon blog](https://laravel.sillo.org).

---

## Tip:

```bash
php artisan optimize && php artisan optimize:clear && php artisan cache:clear && php artisan view:clear && php artisan config:clear
```

→ Vous pouvez d'un seul geste, copier, coller dans votre terminal puis exécuter ces commandes lorsque vous en avez besoin. 😉

*You can directly copy, paste, and execute all of these commands in one go in your terminal when needed.* 😉

---

## Particularités

### Traductions

* Pour la traduction, nous avons à notre disposition 2 nouveaux helpers et une nouvelle directive Blade :
  * transL(*string*)
  * __L(*string*)
  * @langL(*string*)
  
  Ces helpers, extensions des originaux, mais avec un 'L' (Comme Lower Case First) permettent de traduire directement des textes en utilisant la langue choisie par le visiteur, mais en **gardant la première lettre en minuscule**.

  Ainsi, une chaine définie dans un fichier de traduction n'a pas besoin d'être insérée sous 2 formes, même si le plus souvent elle doit commencer par une majuscule, mais qu'elle peut parfois aussi être utilisée dans un autre contexte qui nécessite qu'elle commence alors par une minuscule.

  Exemple :
  
  'Adresse de facturation : ...'
  et ailleurs, peut-êre ne serait-ce pour un tool-tip :
  'Définir votre adresse de facturation', ou dans une liste *

  ```php
  // Dans un fichier de traduction,
  // cette unique insertion dans lang/fr.json :
  "Billing address" : "Adresse de facturation",
  
  // Ou, dans fr/orders.php :
  <?php
  declare(strict_types=1);

  return [
    ...
    'customer' => [
      'Billing address' => 'Adresse de facturation',
    ],
    ...
  ]

  // Permettra d'insérer dans une vue :
  <h2>@lang('Billing address')</h2>
  <span>@langL('Billing address')</span>
  
  // Ou dans l'autre contexte :
  <h2>@lang('orders.customer.Billing address')</h2>
  <span>@langL('orders.customer.Billing address')</span>
  // Ou :
  <h2>{{ __('orders.customer.Billing address') }}</h2>
  <span>{{ __L('orders.customer.Billing address') }}</span>
  // Ou encore :
  <h2>{{ trans('orders.customer.Billing address') }}</h2>
  <span>{{ transL('orders.customer.Billing address') }}</span>
  ```

  Chacune de ces vues donnera respectivement ce code source HTML :

  ```html
    <h2>Adresse de facturation</h2>,
    <span>adresse de facturation</span>.
  ```

---

* : À la base, j'étais curieux de vérifier avec Chat GPT... :

```bash
Dans une liste non ordonnée, avec des tirets devant les items,
ceux-ci doivent ils être écrits en commençant par une majuscule
ou une minuscule ?

- Bonne question ! En général, dans une liste non ordonnée avec des tirets,
les items commencent par une minuscule, sauf si c'est un nom propre
ou une abréviation qui doit alors être en majuscule.

Par exemple :

- acheter du pain
- appeler Jean
- vérifier les emails

Cela permet d'assurer une certaine uniformité et de faciliter la lecture.
```
---

## RoadMap

### Problèmes observés/Objectifs (Planifiés [ ], en cours [/] et résolus/réalisés [x])

---

* //[ ] Config dans le Docker dev, de VSC auto-démarré avec certaines extensions utiles (Todo, Database, Config des couleurs dans le code, etc...)

* //[ ] Supression de tous les $adaptedReq (Adaptation des reqs pour PostGres + SqLite, vu que même environement pour tous les devs)
  
* //[ ] Docker: Création d'un dépôt pour dev de Sillo-Shopen 1 clic): Nginx, MySQL, PhpMyAdmin, MailPit intégré
  
* //[ ] Docker: Création d'un dépôt public de Sillo-Shop démo (en 1 clic: Ouverture auto du browser avec visu. du site + 1 fenêtre pour visu. des emails émis par le site en HTML (MailPit:8025)

---

* ...
* //[ ] Shop : Les frais de port
* //[ ] Shop : Les pages
* //[ ] Shop : Les pays
* //[ ] Shop : États de commande
* //[ ] Shop : La boutique
* //[ ] Shop : Le catalogue
* //[/] Shop : Les clients

---

* [x] Listings clients: hover Client → Delivery address
* [x] Création d'un service pour req orders pour pages utilisant orders/table
* [x] Filtrage pour autoriser le tri / Client que pour orders/index (Puisque ça marche) et inactif dans listing de l'accueil Dashbord
* [x] Désactivation globale du tri / client (Vu que problème dans listing accueil Dashboard
* [x] Amélioration listing Client (orders/index)
  * [x] Meilleures têtes de colonnes du listing
  * [x] N° de Commande & Facture comme réels
* [x] Listing client - Tri / client bug si SqLite → Fix
* [x] Lien pour Dashbord Front-End petit écran
