# 🚀 Secure Core API

This is a high-load, robust Task Management API built with **Laravel 13**, focusing on **Clean Architecture**, **SOLID principles**, and **Test-Driven Development (TDD)**.

## 🛠 Tech Stack
* **Framework:** Laravel 13.x (Latest Stable)
* **PHP:** 8.3+
* **Database:** MySQL 8.4 / PostgreSQL 17
* **Testing:** Pest 3.x (Feature & Unit tests)
* **Documentation:** [Scramble](https://scramble.dedoc.co/) (Modern, Zero-config OpenAPI 3.1)
* **Auth:** Laravel Sanctum (Stateful API Authentication)

---

## ✨ Key Features
* **Custom Role System:** Enterprise-grade logic for `Admin` and `User` roles using a Repository-Service pattern.
* **Secure Role Management:** Dedicated endpoints for role promotion/demotion with strict **Self-Action Prevention** policies.
* **Clean Architecture:** Strict layer separation using **DTOs**, **Repositories**, and **Services** to ensure scalability.
* **Advanced Exception Handling:** Custom global rendering for Validation, Authentication, and Authorization (403) errors.
* **Strict Mode Enabled:** Enforced `Model::shouldBeStrict()` to prevent N+1 queries and lazy loading violations in production.

---

## 📖 API Documentation
The documentation is automatically generated in real-time, scanning your FormRequests and Resources to provide an interactive playground.

👉 **URL:** `http://localhost:8000/docs/api`

---

## 🧪 Testing Suite
We maintain **100% Code Coverage** for core business logic using **Pest**.

### Feature Tests
Located in `tests/Feature`, these validate the entire HTTP lifecycle:
* **Role-Based Access Control (RBAC):** Verifying middleware and policy enforcement.
* **Data Integrity:** Ensuring transactions rollback correctly on failure.

### Unit Tests
Located in `tests/Unit`, focusing on isolated logic:
* **Service Layer Mocking:** Testing `AdminUserService` with mocked repositories for speed.
* **DTO Mapping:** Validating data consistency between the Controller and Service layers.

**Run the suite:**
```bash
php artisan test
```

---

## ⚙️ Installation & Setup

1.  **Clone & Enter:**
    ```bash
    git clone https://github.com/ggorr13/secure-core-api.git
    cd secure-core-api
    ```

2.  **Install PHP & JS Dependencies:**
    ```bash
    composer install
    ```

3.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Strategy:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Serve:**
    ```bash
    php artisan serve
    ```

---
