# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is **OpenSID** (Sistem Informasi Desa / Village Information System) — an open-source village administration system for Indonesian villages, maintained by Perkumpulan Desa Digital Terbuka. GPL-3.0-or-later.

- **Version:** `2504.0.0` (public/UMUM edition), defined as `VERSION` in `donjo-app/helpers/opensid_helper.php`.
- **PHP:** `composer.json` requires `^8.1`, but the installer (`donjo-app/config/installer.php`) only accepts **PHP 8.1–8.2** and rejects 8.3+. Match the runtime to that range.

## This Checkout vs. Upstream Dev

This is a **deployed, single-village production instance**, not a clean dev checkout. That changes what works:

- **Not a git repository** and installed with **`composer install --no-dev`** (`vendor/composer/installed.json` → `"dev": false`). The dev toolchain (phpunit, php-cs-fixer, rector, composer-normalize, faker) is **not in `vendor/`**; `vendor/bin/` has only carbon, doctrine-dbal, var-dump-server, patch-type-declarations.
- There is **no `tests/` directory, no `phpunit.xml`, no style configs** (`.php-cs-fixer*.php`, `rector.php`, `.prettierrc`), and **no root `package.json`** here. So `composer phpunit` and `composer style-fix` **fail out of the box** — they need a full `composer install` (with dev deps) plus the upstream `tests/`/config files restored first.
- **No `.env` / dotenv anywhere.** All configuration is CI-style PHP under `donjo-app/config/*.php`, bridged into Laravel by `config/*.php`. Real per-village DB credentials live in `desa/config/database.php` (see Database).

## Commands

```bash
# Install dependencies (use without --no-dev to get the test/lint toolchain)
composer install

# Run tests — requires dev deps + an upstream tests/ dir + phpunit.xml (absent here)
composer phpunit                         # = vendor/bin/phpunit tests
vendor/bin/phpunit --filter <TestName>   # single test, once phpunit is installed

# Code style fix — needs dev deps, a root package.json, and style configs (absent here)
composer style-fix                       # npm run prettier-blade && php-cs-fixer fix --allow-risky=yes && rector process

# Laravel artisan commands (bridged through CI — see Architecture)
php artisan <command>
```

**Dev mode:** `index.php` sets `ENVIRONMENT` from `$_SERVER['CI_ENV']` (default `production`). For **HTTP** requests this must come from the web server (e.g. Apache `SetEnv CI_ENV development`) — a shell `export CI_ENV=development` only reaches **CLI** invocations like `CI_ENV=development php artisan ...`. This instance's `.htaccess` has no `SetEnv`.

## Architecture

A **hybrid CodeIgniter 3 + Illuminate 10 (Laravel components)** app bridged by the custom `opensid/router` package (namespace `OpenSID\`, at `vendor/opensid/router/`). Understanding this dual-framework design is critical.

### Framework Split

| Layer | Framework | Location |
|-------|-----------|----------|
| HTTP routing & controllers | CodeIgniter 3 | `donjo-app/controllers/` |
| ORM / Models | Eloquent (Illuminate 10) | `app/Models/` |
| Views | Blade (primary) + CI views | `resources/views/`, `donjo-app/views/` |
| Public-site views | Theme system | `vendor/themes/`, `desa/themes/` |
| Service layer | Laravel | `app/Services/`, `app/Repository/` |
| Events, queues, notifications | Laravel | `app/Events/`, `app/Listeners/` |
| Artisan commands | Laravel | `app/Console/Commands/` |

### How It Boots (the CI ↔ Laravel bridge)

The glue is **`donjo-app/config/hooks.php`**, active because `donjo-app/config/config.php` sets `enable_hooks = true`. It does two things:

1. Registers the `opensid/router` CI hooks via `getHooks(...)` → `OpenSID\Hook` registers 5 CI hooks (`pre_system`, `pre_controller`, `post_controller_constructor`, `post_controller`, `display_override`). Routes are globbed/compiled in the `pre_system` hook.
2. Boots Laravel: `$app = require bootstrap/app.php; $app->run();`.

**`bootstrap/app.php` is NOT a standard Laravel Foundation app.** It builds `new App\Services\Laravel(FCPATH)` — a ~1100-line **Lumen-style micro-container** extending `Illuminate\Container\Container`. Illuminate **components** (db, view, cache, queue, mail, events…) are registered lazily via an `availableBindings` map + `loadComponent()`. To add a service/provider/facade, **edit `bootstrap/app.php`** (`register(...)`, `configure(...)`, `alias(...)`, `withFacades()`), **not** a `config/app.php` providers array. Registered facade aliases are fixed in `withAliases()`: `Cache, DB, Event, Log, Queue, Schema, Storage, Validator`.

`$app->withEloquent()` calls `make('db')`, which sets `Model::setConnectionResolver` — that is why `SomeModel::find()` works statically from inside CI controllers with no per-request wiring. The DB binding is **gated on `desa/` existing** (`registerDatabaseBindings()` only `configure('database')` when installed), so Eloquent has no connection on a fresh, un-installed instance.

To reach the CI side from router helpers, `ci()` (alias of `get_instance()`) returns the active CI controller.

### Request Flow

1. `index.php` — CI3 front controller; app dir `donjo-app`, system in `vendor/codeigniter/framework/system`.
2. CI fires the `pre_system` hook → router compiles routes and matches the URL (supports `_method` POST field for PUT/DELETE; `{name}` / `{name?}` params; `route('name', [...])` helper; unmatched URLs hit the `404_override` route → `show_404()`).
3. The matched **CI controller** runs, calling Eloquent models / services.
4. Controller renders a **Blade** view (`view(...)`) or a CI view (`$this->load->view(...)`).

### Routing

Route files (loaded by the router):

- `donjo-app/Routes/web.php` — public website; **also `require_once`'s every `donjo-app/Routes/Web/*.php` at its tail** (that's how `admin.php`/`mandiri.php` load — the router core only globs the three top-level files).
- `donjo-app/Routes/Web/admin.php` — the admin panel (a ~167KB file).
- `donjo-app/Routes/Web/mandiri.php` — self-service portal (`anjungan-mandiri`, `layanan-mandiri`).
- `donjo-app/Routes/api.php` — REST API: `internal_api` and `external_api` groups (the latter incl. `sign`/`pdf`, `tte`). Loaded for AJAX/web inside `RouteAjaxMiddleware`.
- `donjo-app/Routes/console.php` — CLI routes (`Route::cli`); includes the `artisan/{...}` bridge to `Artisan@index`. Loaded only under CLI.
- Module routes are **auto-discovered**: the `pre_system` hook globs `Modules/*/Routes/web.php` and `*/Routes/api.php`.

**`/siteman/` is the admin _login_ URL, not an admin path prefix.** In `admin.php` only the `siteman` group covers auth (login/logout/`lupa_sandi`/reset). The rest of the admin panel is at **top-level** paths (`/main`, `/beranda`, `/pengguna`, `/wilayah`, `/identitas_desa`, …). Admin login controller: `donjo-app/controllers/auth/AuthenticatedSessionController.php`. The self-service portal has a **separate** login at `donjo-app/controllers/fmandiri/auth/AuthenticatedSessionController.php` (`/layanan-mandiri/masuk`).

### Controllers

Controllers are **plain CI3 classes with NO PHP namespace**. A route's `'namespace'` option maps to a **subdirectory** under `donjo-app/controllers/` (CI directory routing), e.g. `auth/`, `fweb/`, `fmandiri/`, `fmandiri/anjungan/`, `internal_api/`, `external_api/`. Targets are CI-style `'Controller@method'` strings. There are 160+ controllers.

**Pick the right base controller** (all in `donjo-app/core/`) — it determines auth guard and template/theme behavior:

| Base | Extends | Use for |
|------|---------|---------|
| `MY_Controller` | `CI_Controller` | core base (runs install/app-key/setting init) |
| `Admin_Controller` | `MY_Controller` | admin panel (~134 ctrls, guard `admin`) |
| `Web_Controller` | `MY_Controller` | public site (loads the active theme) |
| `Mandiri_Controller` | `MY_Controller` | self-service portal |
| `Api_Controller` | `MY_Controller` | API |
| `Anjungan_Controller` | `Admin_Controller` | kiosk |

A handful (e.g. `Artisan`, `Install`) extend `CI_Controller` directly.

### Views & Themes

- The **admin panel is predominantly Blade** now (`view()` is used ~309× vs `$this->load->view()` ~71×). Admin Blade lives in `resources/views/admin/`; `donjo-app/views/` holds the older remaining CI views.
- The **public website is NOT rendered from `resources/views/`** — it uses an installable **theme system**. System themes are composer packages in `vendor/themes/` (`themes/esensi`, `themes/natra`); village/custom themes live in `desa/themes/`. The active theme comes from the DB setting `web_theme` (`donjo-app/models/Theme_model.php`: a `desa/`-prefixed value → `desa/themes`, else `vendor/themes`; default `esensi`). `theme_active()` is cached via `cache()->rememberForever('theme_active')`, so **clear cache after switching themes**. To change public-site markup, edit the theme (`template.php`, `layouts/`, `partials/`), not `resources/views/`.

### Database, Models & Migrations

**Config / credentials.** `donjo-app/config/database.php` (CI `$db` array) is translated into Laravel connections by `config/database.php` (mysqli→mysql, postgre→pgsql, etc.; Redis preconfigured). But the **real per-village credentials are in `desa/config/database.php`** (gitignored — its header says *"JANGAN di-commit ke GIT"*), which `donjo-app/config/database.php` `include`s and which **overrides** the defaults (this install: db `desa-dukuh`). A stored password longer than 80 chars is auto-decrypted at runtime via the Laravel encrypter. **Change DB connection in `desa/config/database.php`, not `donjo-app/config/database.php`.** Multi-village mode branches on `setting('multi_desa')`.

**Models.** `app/Models/` holds **172** files (all top-level, no subdirs); **168 extend `App\Models\BaseModel`** (which extends `Illuminate\Database\Eloquent\Model`). Exceptions: `BaseModel` itself, `PendudukSaja` (extends `Penduduk`), and the encoded premium files `Anjungan`/`AnjunganMenu`. `BaseModel` adds little: it overrides `findOrFail()`/`firstOrFail()` to call CI's `show_404()` instead of throwing, and adds a static `gantiStatus($id, $kolom, $onlyOne)` toggle (`StatusEnum` YA/TIDAK). Conventions: tables are explicit `$table` with **Indonesian names that do not pluralize** (`penduduk`, `tweb_penduduk`) — never rely on auto-inference; **no model uses `SoftDeletes`**; ~71 set `$timestamps = false`; ~83 define query scopes; a few override `$primaryKey`.

**Migrations — a fully custom runner (NOT CI migrate, NOT `php artisan migrate`).** The CI migration library is disabled (`migration_enabled = false` in `donjo-app/config/migration.php`) and is a red herring. Instead:

- `donjo-app/models/Database_model.php` → `cek_migrasi()`/`migrasi_db_cri()` scans `donjo-app/models/migrations/` (`directory_map(...)`, sorted by filename), and for each `Migrasi_<num>` whose number isn't yet in the `migrasi` table, `jalankan_migrasi()` loads it as a **CI model** (extends `MY_Model`, with `up()`/`down()`) and calls `up()`. It also always runs `migrasi_beta`/`migrasi_rev` at the end.
- Files are named `Migrasi_<YYYYMMDD+seq>.php` (full year). Plus non-dated runners `Migrasi_beta.php`, `Migrasi_rev.php`, and `Data_awal.php`.
- The **base (fresh-install) schema** is `donjo-app/models/migrations/struktur_tabel/` — **438 Laravel-style migration files** (248 create-table + 190 add-foreign-key, each `return new class extends Migration`). These are bulk-loaded — `require`d and `->up()` in a `foreach` — by **`donjo-app/models/seeders/Data_awal_seeder::run()`** (the install seeder), **not** by `php artisan migrate` and **not** by `Migrasi_<...>.php` (a regular dated migration may `require` one or two of them individually, but does not loop the whole dir).
- Applied versions are tracked in the **`migrasi` table** (`App\Models\Migrasi`, column `versi_database`, plus a `premium` json column) — **not** `migrations`. Trigger from the admin **Database** page (`donjo-app/controllers/Database.php::migrasi_db_cri()`, requires `isCan('u')`): it deletes the last `migrasi` row (or **all** rows with `?mode=all`) then calls `cek_migrasi()`, so `?mode=all` forces a full re-migration.
- Seeders/reference data live in `donjo-app/models/seeders/` (`Data_awal_seeder.php`, `dataAwal/`). There is **no** root `database/` directory.

### Key Directories

- `app/Models/` — 172 Eloquent models (168 extend `BaseModel`).
- `donjo-app/controllers/` — 160+ CI controllers (namespaced by subdirectory).
- `donjo-app/core/` — base controllers (`MY_Controller`, `Admin_Controller`, …) and `MY_Model`.
- `donjo-app/helpers/` — global helper functions (see below).
- `donjo-app/config/` — CI config, **including the `hooks.php` bridge**.
- `bootstrap/app.php`, `app/Services/Laravel.php` — the Laravel micro-container.
- `desa/` — **per-village runtime state, not source code**: `config/` (settings + DB creds + app_key), `upload/`, `arsip/`, `logo/`, `template-surat/`, `themes/`, `widgets/`, `cache/`, plus a DB dump. `desa/config/*` is gitignored. **Do not edit, regenerate, or commit this data.**
- `Modules/` — plugin system, currently **empty** (only `.gitkeep`/`.htaccess`/`index.html`); drop `Modules/<name>/Routes/web.php` to auto-register module routes.
- `assets/` — frontend assets (Bootstrap 3, AdminLTE).
- `storage/app/vendor/` — copied from `vendor/` by `slowprog/composer-copy-file` on every install/update.
- `dukuh-indramayu.desa.id/` — **ignore**: a leftover hosting/domain artifact (empty `public_html/` + a `DO_NOT_UPLOAD_HERE` marker), unrelated to the app.

### Helper Functions

Three global helper files are autoloaded in dev via `composer.json` (`autoload-dev.files`); in production CI's autoload loads them:
- `donjolib_helper.php`
- `general_helper.php`
- `opensid_helper.php` (also defines `VERSION`)

### Notable Integrations

- **PDF**: `spipu/html2pdf` (generation), `karriere/pdf-merge` (merging); TTE digital signatures via external API (`external_api/Tte.php`, `external_api/Sign.php`).
- **Spreadsheet**: `openspout/openspout` + `rap2hpoutre/fast-excel` for Excel import/export.
- **Notifications**: Telegram (`laravel-notification-channels/telegram`); FCM via the **legacy** `edwinhoksberg/php-fcm` (not firebase-admin) — see `app/Models/FcmToken*.php`.
- **Google**: Drive and Apps Script via `google/apiclient` (only `Script` and `Drive` services are loaded; restricted in `composer.json` `extra`).
- **Thermal printing**: `mike42/escpos-php`.
