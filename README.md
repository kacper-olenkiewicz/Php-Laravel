# 🏭 System Wypożyczalni Sprzętu — Laravel 12

> **Multi-tenant SaaS** do zarządzania wieloma wypożyczalniami sprzętu, rezerwacjami, płatnościami i użytkownikami.

![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)
![Laravel 12](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![Filament 4](https://img.shields.io/badge/Filament-4-FDAE4B?logo=laravel&logoColor=white)
![Livewire 3](https://img.shields.io/badge/Livewire-3-FB70A9?logo=livewire&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?logo=sqlite&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Spis treści

1. [Opis projektu](#-opis-projektu)
2. [Funkcjonalności](#-funkcjonalności)
3. [Architektura & Tech-stack](#-architektura--tech-stack)
4. [Wymagania](#-wymagania)
5. [Instalacja krok po kroku](#-instalacja-krok-po-kroku)
6. [Uruchamianie](#-uruchamianie)
7. [Struktura katalogów](#-struktura-katalogów)
8. [Role i uprawnienia](#-role-i-uprawnienia)
9. [Schemat bazy danych](#-schemat-bazy-danych)
10. [API (opcjonalnie)](#-api-opcjonalnie)
11. [Testowanie](#-testowanie)
12. [Autor](#-autor)

---

## 📖 Opis projektu

Aplikacja webowa umożliwiająca:
- **SuperAdmin**: zarządzanie wszystkimi wypożyczalniami (tenantami), przeglądanie statystyk globalnych, zarządzanie klientami.
- **Właściciel wypożyczalni (RentalOwner)**: pełna kontrola nad produktami, kategoriami, rezerwacjami i płatnościami w ramach własnej wypożyczalni.
- **Pracownik (Employee)**: obsługa rezerwacji i płatności (uprawnienia konfigurowane).
- **Klient (Customer)**: przeglądanie katalogu, tworzenie rezerwacji i śledzenie historii.

Projekt realizowany jako **zadanie 9-12** — Olenkiewicz, nr albumu 20470.

---

## ✨ Funkcjonalności

| Moduł | Opis |
|-------|------|
| **Katalog produktów** | Publiczna strona z listą produktów, wyszukiwarką, filtrami kategorii. |
| **Rezerwacje** | Klient wybiera produkty, daty i składa rezerwację. Właściciel/pracownik potwierdza lub anuluje. |
| **Płatności** | Rejestracja płatności za rezerwację, potwierdzanie statusu (`pending`, `completed`, `failed`). |
| **Panel Rental** | Dashboard właściciela/pracownika: statystyki, lista rezerwacji, zarządzanie produktami. |
| **Panel Admin** | Dashboard SuperAdmina: globalne statystyki, CRUD wypożyczalni, lista klientów. |
| **Filament Admin** | Alternatywny panel administracyjny pod `/admin` (Filament 4). |
| **Autoryzacja Spatie** | Role i uprawnienia: `SuperAdmin`, `RentalOwner`, `Employee`, `Customer`. |
| **Soft Deletes** | Bezpieczne usuwanie (bez utraty danych) dla wypożyczalni, produktów, rezerwacji, płatności. |

---

## 🛠 Architektura & Tech-stack

```
┌─────────────────────────────────────────────────────────────┐
│                        Frontend                             │
│  Blade + Livewire 3 + Tailwind CSS / Bootstrap              │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                      Laravel 12                             │
│  ┌──────────┐  ┌──────────────┐  ┌───────────────────────┐  │
│  │ Routing  │→ │ Controllers  │→ │ Eloquent Models       │  │
│  │ web.php  │  │ Rental/Admin │  │ Booking, Product, ... │  │
│  └──────────┘  └──────────────┘  └───────────────────────┘  │
│  ┌─────────────────────┐   ┌────────────────────────────┐   │
│  │ Spatie Permissions  │   │ Filament 4 (Admin Panel)   │   │
│  └─────────────────────┘   └────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
                   ┌────────────────┐
                   │    SQLite      │
                   │  database.sqlite│
                   └────────────────┘
```

**Główne pakiety:**

| Pakiet | Wersja | Cel |
|--------|--------|-----|
| `laravel/framework` | 12.x | Rdzeń aplikacji |
| `filament/filament` | 4.x | Panel administracyjny |
| `livewire/livewire` | 3.x | Komponenty reaktywne |
| `spatie/laravel-permission` | latest | Role & uprawnienia |
| `laravel/breeze` | 2.x | Autentykacja (Blade) |
| `laravel/sanctum` | latest | Tokeny API |

---

## 📦 Wymagania

- **PHP** ≥ 8.2 (z rozszerzeniami: `pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`)
- **Composer** ≥ 2.5
- **Node.js** ≥ 18 + **npm** ≥ 9
- **Git**

---

## 🚀 Instalacja krok po kroku

```bash
# 1. Klonowanie repozytorium
git clone https://github.com/<twoja-nazwa>/Php-Laravel.git
cd Php-Laravel/zad9_12_projekt_Olenkiewicz_20470

# 2. Instalacja zależności PHP
composer install

# 3. Konfiguracja środowiska
cp .env.example .env
php artisan key:generate

# 4. Utworzenie bazy danych SQLite
touch database/database.sqlite

# 5. Migracje i seedery
php artisan migrate --seed

# 6. Instalacja zależności JS
npm install

# 7. Budowanie assetów (produkcja) lub tryb dev
npm run build    # produkcja
# lub
npm run dev      # development (HMR)
```

> **Tip:** Możesz też użyć skrótu:
> ```bash
> composer setup   # wykonuje kroki 2-7 automatycznie
> ```

---

## ▶️ Uruchamianie

### Tryb deweloperski (HMR + queue + logs)

```bash
composer dev
```

Polecenie uruchamia równolegle:
- `php artisan serve` — serwer HTTP na `http://127.0.0.1:8000`
- `php artisan queue:listen` — obsługa kolejek
- `php artisan pail` — podgląd logów
- `npm run dev` — Vite HMR

### Tryb produkcyjny

```bash
npm run build
php artisan serve --env=production
```

---

## 📁 Struktura katalogów

```
zad9_12_projekt_Olenkiewicz_20470/
├── app/
│   ├── Filament/          # Zasoby panelu Filament
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/     # SuperAdmin: RentalController, ClientController
│   │   │   ├── Rental/    # Panel wypożyczalni: Products, Categories, Bookings, Payments
│   │   │   └── Client/    # Klient: BookingController
│   │   ├── Middleware/    # ScopeToRental, EnsureUserHasRole, itp.
│   │   └── Requests/      # FormRequests (walidacja)
│   ├── Models/            # Eloquent: User, Rental, Product, Category, Booking, Payment...
│   ├── Providers/         # AppServiceProvider, Filament Panel Providers
│   └── Traits/            # HasRentalScope (multi-tenancy scope)
├── database/
│   ├── factories/         # Fabryki modeli (Faker)
│   ├── migrations/        # Migracje schematu
│   └── seeders/           # DatabaseSeeder + pomocnicze
├── resources/
│   ├── views/
│   │   ├── admin/         # Widoki panelu SuperAdmin
│   │   ├── rental/        # Widoki panelu właściciela/pracownika
│   │   ├── client/        # Widoki klienta (rezerwacje)
│   │   ├── layouts/       # Layouty (app, guest, navigation)
│   │   └── components/    # Blade components
│   ├── css/               # Tailwind / custom CSS
│   └── js/                # Alpine, Livewire assets
├── routes/
│   ├── web.php            # Trasy webowe
│   ├── api.php            # Trasy API (Sanctum)
│   └── auth.php           # Autentykacja (Breeze)
├── tests/                 # PHPUnit Feature & Unit
├── .env.example
├── composer.json
├── package.json
└── vite.config.js
```

---

## 🔐 Role i uprawnienia

System wykorzystuje **Spatie Laravel Permission**:

| Rola | Opis | Kluczowe uprawnienia |
|------|------|----------------------|
| `SuperAdmin` | Administrator globalny | pełny dostęp, zarządzanie wszystkimi tenantami |
| `RentalOwner` | Właściciel wypożyczalni | `manage products`, `manage bookings`, `process payments`, `view reports` |
| `Employee` | Pracownik wypożyczalni | konfigurowalne (np. tylko `manage bookings`) |
| `Customer` | Klient | przeglądanie katalogu, tworzenie rezerwacji, historia zamówień |

**Middleware:**
- `role:RoleName` — sprawdza przypisaną rolę
- `permission:name` — sprawdza uprawnienie
- `scope.rental` — ogranicza dane do bieżącego tenanta (rental_id)

---

## 🗃 Schemat bazy danych

Pełny opis tabel z kolumnami i relacjami znajdziesz w pliku **[Baza.txt](./Baza.txt)**.

### Diagram ER (uproszczony)

```
┌────────────┐       ┌────────────┐       ┌─────────────┐
│   users    │───────│  rentals   │───────│  categories │
└────────────┘  N:1  └────────────┘  1:N  └─────────────┘
      │                    │                     │
      │ 1:N                │ 1:N                 │ M:N (pivot)
      ▼                    ▼                     ▼
┌────────────┐       ┌────────────┐       ┌──────────────────┐
│  bookings  │───────│  products  │───────│product_categories│
└────────────┘       └────────────┘       └──────────────────┘
      │ 1:N                │ 1:N
      ▼                    ▼
┌──────────────┐     ┌──────────────┐
│booking_items │     │   payments   │
└──────────────┘     └──────────────┘
```

**Główne tabele biznesowe:**
- `rentals` — wypożyczalnie (tenanci)
- `products` — sprzęt do wypożyczenia
- `categories` — kategorie produktów
- `bookings` — rezerwacje klientów
- `booking_items` — pozycje rezerwacji
- `payments` — płatności

**Tabele systemowe / auth:**
- `users`, `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`

---

## 🌐 API (opcjonalnie)

Aplikacja zawiera zestaw endpointów REST pod `/api` (chronione tokenami Sanctum).

```http
GET    /api/products           # lista produktów
GET    /api/products/{id}      # szczegóły produktu
POST   /api/bookings           # utwórz rezerwację
GET    /api/bookings           # moje rezerwacje
```

Autoryzacja nagłówkiem:
```
Authorization: Bearer <personal_access_token>
```

---

## 🧪 Testowanie

```bash
# Uruchomienie wszystkich testów
php artisan test

# Lub przez PHPUnit bezpośrednio
./vendor/bin/phpunit
```

Testy znajdują się w `tests/Feature` i `tests/Unit`.

---

## 👤 Autor

**Olenkiewicz** — *nr albumu 20470*

Projekt wykonany w ramach zadania 9-12 na przedmiot programowania w PHP/Laravel.

---

## 📄 Licencja

Projekt jest udostępniony na licencji **MIT** — zobacz [LICENSE](./LICENSE).