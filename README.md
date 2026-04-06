# 🚀 Secure Core API

This is a high-performance, robust Task Management API built with **Laravel 13**. While the project is lightweight, it is architected with a **Production-Ready Mindset**, utilizing professional design patterns to ensure maximum maintainability, security, and testability.

---

## 🔗 API Access & Documentation
The API is configured to run locally by default:
* 👉 **Base URL:** `http://localhost:8000/api`
* 👉 **Interactive API Docs:** `http://localhost:8000/docs/api` (Powered by Scramble)

---

## 🏗 Architectural DNA
Instead of over-engineering a focused-scale project with full "Clean Architecture" boilerplate, this API implements a **Decoupled Layered Pattern** that strictly prioritizes **SOLID** principles and **TDD**:

* **DTOs (Data Transfer Objects):** The single source of truth for data flowing between layers. No more "array-hunting" — just strict type safety and IDE autocompletion.
* **Service Layer:** All business logic is centralized here, keeping Controllers thin and focused only on the HTTP lifecycle.
* **Repository Pattern:** Complete abstraction of data persistence through **Interfaces**, allowing for seamless mocking in tests and decoupling from the Eloquent ORM.
* **Dependency Injection:** Full utilization of Laravel's Service Container to manage dependencies and enhance testability.

---

## 🛠 Tech Stack
* **Framework:** Laravel 13.x (Latest Stable)
* **PHP:** 8.3+ (Strictly typed)
* **Database:** MySQL 8.4 / PostgreSQL 17
* **Testing:** Pest 3.x (Modern TDD suite)
* **Documentation:** [Scramble](https://scramble.dedoc.co/) (Zero-config OpenAPI 3.1)

---

## 🧪 Testing & Reliability
This project follows a strict **Test-Driven Development (TDD)** workflow to ensure 100% reliability of core business rules.

* **Pest 3.x:** Elegant and fast testing for both Feature and Unit layers.
* **Mockery:** Used to isolate the Service layer by mocking Repository dependencies, ensuring unit tests execute in milliseconds.
* **100% Core Coverage:** Every critical path (Authentication, RBAC, Data Integrity) is backed by an automated test.

**Run the suite:**
```bash
php artisan test
```

---

## ✨ Key Features
* **Role-Based Access Control (RBAC):** Managed via strict Laravel Policies and Gates to prevent unauthorized access.
* **Strict Mode Enabled:** Enforced `Model::shouldBeStrict()` to catch N+1 queries and lazy loading violations during development.
* **Atomic Transactions:** All multi-step database operations are wrapped in `DB::transaction` within Repositories to ensure data integrity.
* **Standardized API Resources:** Consistent JSON structure for all responses and error handling via Eloquent Resources.

---

## ⚙️ Installation & Setup

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/ggorr13/secure-core-api.git](https://github.com/ggorr13/secure-core-api.git)
    cd secure-core-api
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    ```

3.  **Environment Configuration:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Migration & Seeding:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Run the application:**
    ```bash
    php artisan serve
    ```

---

### Developed by **Gor**
*Focused on Clean Code, SOLID principles, and Scalable Backend Solutions.*
