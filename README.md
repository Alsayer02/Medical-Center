# 🏥 Modern Medical Center Management System

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![Filament](https://img.shields.io/badge/Filament-3.2-EBB308?style=for-the-badge&logo=laravel)
![Sanctum](https://img.shields.io/badge/Auth-Sanctum-orange?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

A robust, enterprise-grade **RESTful API** and **Administrative Dashboard** built with Laravel 11. This system manages healthcare workflows, including patient registration, doctor scheduling, and medical record keeping with a focus on data integrity and security.

---

## 🌟 Key Features

### 🔐 Multi-Role Authentication
- **Admin Panel:** Powered by **Filament PHP**, providing a sleek UI for managing the entire center.
- **RESTful API:** Secured by **Laravel Sanctum** for mobile or frontend integration.
- **Role-Based Access Control (RBAC):** Strict permissions using Laravel **Policies** and **Gates**.

### 👨‍⚕️ Healthcare Management
- **Doctor-User Synchronization:** Seamless One-to-One relationship management between System Users and Doctors.
- **Patient Management:** Comprehensive tracking of patient demographics and history.
- **Appointment System:** Real-time scheduling with status tracking (Pending, Approved, Rejected).
- **Medical Records:** Centralized diagnostic data and doctor notes.

### 📊 Advanced Analytics
- **Live Widgets:** Statistical charts (Trend) showing appointment volumes and patient growth directly on the dashboard.

---

## 🛠 Technical Excellence (Code Highlights)

- **Atomic Transactions:** Uses a custom `HandleTransaction` Trait to ensure that multi-step database operations (like creating a User and a Doctor simultaneously) either succeed completely or fail gracefully without leaving "orphan" data.
- **Clean API Resources:** Standardized JSON responses across all endpoints for better frontend consumption.
- **Secure Validation:** Isolated business logic from validation using specialized **Form Requests**.
- **Data Integrity:** Implemented `booted()` model methods for cascading deletes and automated user cleanup.

---

## 📂 Project Architecture

```text
├── app
│   ├── Filament         # Admin Dashboard Logic & Widgets
│   ├── Http
│   │   ├── Controllers  # Clean RESTful API Controllers
│   │   ├── Requests     # Strict Input Validation
│   │   └── Resources    # JSON Transformation Layer
│   ├── Models           # Eloquent Relationships & Scopes
│   ├── Policies         # Authorization Logic
│   └── Traits           # Reusable Logic (Database Transactions)
└── routes
    └── api.php          # Protected API Endpoints
