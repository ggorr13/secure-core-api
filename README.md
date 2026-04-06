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
