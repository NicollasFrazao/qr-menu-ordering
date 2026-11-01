# Comanda Digital (qr-menu-ordering)

Table-side ordering web app: the customer scans the QR code on the table, browses the restaurant's menu, builds an order and follows the tab ("comanda"), while staff see incoming orders in an admin panel.

Context: Freelance project for a food-tech client. The client's brand has been replaced by the neutral name "Comanda Digital"/"App", partner restaurant names and logos were removed, and OAuth and database credentials were blanked.

## What it does

Customer side (a single-page Blade view, `/app`, that swaps screens with jQuery):

- Social login with Google or Facebook through Laravel Socialite. On first login the user is created in the `tb_usuario` table; the user id, name and photo are kept in the session.
- Store list with a text search over store name and description.
- QR code scanning in the browser camera (Instascan). A scanned code is matched against `tb_card` (one card per table); a match opens a new tab (`tb_comanda`) linked to that table and store.
- Menu browsing by category, then by size; prices come from a product/size price table (`tb_valor`).
- Split items: for categories that allow it (the size defines how many fractions, `vl_fracao`), the customer picks several flavours for one item, and the item is charged at the price of the most expensive flavour.
- The tab: list items, remove items not yet sent, see the running total, add a note to the order, send the pending items to the kitchen, and close the tab.
- Session restore: on reload, an open tab brings the customer back to the store's menu.

Admin side (`/admin`):

- Employee login against `tb_funcionario`; each employee sees only the modules assigned to them (`tb_funcionario_modulo`).
- "Wishlist" module: a queue of sent orders for the employee's store, refreshed by long polling (up to 10 checks, 2 s apart, per request). Selecting an order shows its items and note; "ready" moves the order and its sent items to status 2.
- A "Box" module exists only as a placeholder screen.

All customer and admin actions are POST endpoints under `/ajax/*` in a single controller (`app/Http/Controllers/AjaxController.php`), using the query builder directly (no Eloquent models for the domain tables).

## Tech stack

- PHP 7.1.3+, Laravel 5.7 (locked at 5.7.14)
- Laravel Socialite 3.2 (Google and Facebook)
- MySQL, through a second connection named `mpp` in `config/database.php`
- Blade views, jQuery, Owl Carousel, Bootbox, Instascan for QR reading (jsQR, qr-scanner and ZXing are also bundled, used only by test pages)
- Laravel Mix 2 / Vue 2 scaffolding from the Laravel skeleton is present but not used by the app screens

## Running locally

Requirements: PHP 7.1+ (Laravel 5.7 does not run on PHP 8), Composer, MySQL.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

What is missing before it works end to end:

- **The application schema.** The only migrations are Laravel's default `users` and `password_resets`. The tables the app uses (`tb_usuario`, `tb_loja`, `tb_card`, `tb_comanda`, `tb_item`, `tb_item_produto`, `tb_produto`, `tb_valor`, `tb_tamanho`, `tb_categoria_produto`, `tb_loja_categoria`, `tb_funcionario`, `tb_modulo`, `tb_funcionario_modulo`) are not in the repository and have to be created by hand from the queries in `AjaxController`.
- **The `mpp` connection** is hard-coded in `config/database.php` (`app_db` / `app_user`, empty password) instead of reading `.env`.
- **OAuth credentials.** `config/services.php` has empty Google and Facebook client id/secret, with callbacks at `http://localhost/gauth` and `http://localhost/fbauth`.
- **Store logos** are loaded from `public/image/lojas/`, which is not in the repository.
- The admin module screens are fetched with `file_get_contents('https://<host>/...')`, so the admin area needs the app served over HTTPS.
- QR scanning needs camera access, which browsers only grant on HTTPS or localhost.

## Project structure

```
app/Http/Controllers/AjaxController.php    all customer and admin endpoints
app/Http/Controllers/Auth/LoginController   Socialite redirect and callbacks
routes/web.php                              page routes and /ajax/* routes
resources/views/app.blade.php               customer SPA shell (includes one partial per screen)
resources/views/admin*.blade.php            admin shell and modules
public/js/appScript.js, appQR.js            customer screen logic and QR reading
public/js/appScriptAdmin.js                 admin login, modules and order queue
```

## Notes

- The git history is a single import commit (January 2021); earlier development history is not included.
- Passwords for employees are compared in plain text.
- The `/ajax/*` endpoints rely on session values only; there is no auth middleware, and order status changes are not checked against the logged-in employee.
- Some routes point to views that do not exist (`cardapio_categorias`, `cardapio_produtos`, `configuracoes`, `restaurantes`), and `resources/views` still holds unused drafts (`cardapioOLD`, `app2`, `leadbox`, `lista_loja`). `public/testa.html`, `testao.html` and `testinha.html` are QR library experiments.
- There are no tests beyond the Laravel examples.
