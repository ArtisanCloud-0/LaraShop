# LaraShop Market — Enterprise E-Commerce Platform

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-4.x-4E5BA6?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)

**LaraShop Market** is a modern, high-performance e-commerce platform engineered with Laravel 13, Livewire 4, Alpine.js, and Tailwind CSS v4. 

Built using an **Action/Service Domain-Driven Architecture**, the system decouples complex e-commerce workflow operations from presentation layers, delivering strict type safety, financial audit protection, and zero controller bloat.

---

## 📐 System Architecture & Design Strategy

The platform departs from traditional MVC controller bloat by enforcing a clean separation of concerns across single-responsibility domain layers:

* **Actions (`App\Actions`):** Pure execution entry points that bridge HTTP/Livewire inputs to backend execution logic (e.g., `ProcessCheckoutAction`).
* **Services (`App\Services`):** Encapsulated business engines carrying transaction boundaries and data transformations (e.g., `CheckoutService`, `CartService`).
* **Enums & Value Objects (`App\Enums`):** Strict PHP 8 status definitions enforcing state machine transition rules (e.g., `OrderStatus`).

---

## 🚀 Key Problems Solved

### 1. High Abandonment & Guest Checkout Logic
Traditional platforms force registration before purchase, driving up cart abandonment. **LaraShop Market** implements a dual-driver guest and authenticated checkout flow. Guests can complete transactions instantly without account creation barriers while preserving guest session data.

### 2. Financial Ledger & Historical Audit Preservation
In standard systems, changing product prices or deleting variants alters historical invoice records. LaraShop introduces an explicit **Order Ledger system (`order_ledgers` & `order_items`)**:
* Every purchase creates an immutable financial ledger entry storing exact price snapshots in integer cents.
* Foreign keys utilize `restrictOnDelete()` and soft deletes (`withTrashed()`) to ensure discontinued SKUs or modified prices never corrupt historical accounting logs.
* Completed financial records are protected at the Eloquent lifecycle boot level to block post-settlement modifications.

### 3. Inventory Race Conditions & Overselling
Simultaneous checkout requests for limited stock items are wrapped inside atomic database transactions (`DB::transaction`). Stock decrements (`$detail->decrement('stock')`) execute inside strict isolated database locks to guarantee stock integrity under high concurrency.

---

## 🛠️ Tech Stack & Key Technologies

* **Backend Framework:** Laravel 13 (PHP 8.2+)
* **Reactive Frontend Layer:** Livewire 4 + Alpine.js
* **Styling Framework:** Tailwind CSS
