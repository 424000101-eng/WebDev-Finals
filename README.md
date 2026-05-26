# TechPortfolio | Final Integrative Web Project

A responsive, dark-themed academic portfolio platform built with Bootstrap 5 front-end components and integrated with a local server-side PHP validation engine.

## 🔗 Live Deployment Endpoint
- **Live URL:** [https://424000101-eng.github.io/WebDev-Finals/](https://424000101-eng.github.io/WebDev-Finals/)

## 👥 Built By (Team Members)
- **Germin Jay Culi**
- **Allyn Panciles**
- **John Paul Del Rosario**
- **Joshua Litiatco**

----

## 🛠️ Core Project Architecture

### 1. UI/UX Interface Layer
- Implements a customized dark-mode configuration layer using native Bootstrap 5 grid utilities.
- Designed with high-contrast slate aesthetics (`#0f172a`) and interactive emerald accent components (`#10b981`).

### 2. Form Request Architecture
- Async JavaScript form handling using the browser `Fetch API` to ingest data seamlessly without reloading the main window.
- Dynamically displays real-time validation error alerts or successful submission banners directly within the active modal frame interface.

### 3. Server-Side Handling (PHP Architecture)
- Form endpoints route data downstream into a standalone local server processing engine (`contact.php`).
- Enforces strict data sanitization rules via `htmlspecialchars()` to filter text components safely.
- Implements validation loops checking for empty elements and tracking strict message length limitations (minimum 20 characters required).

----

## 🚀 Local Installation & Setup Instructions

To host and interact with the PHP server features on your local machine using **XAMPP**, follow these configuration steps:

### Method A: Running via XAMPP Public Web Directory (Recommended)
1. Download or clone this repository into your local file system.
2. Move or copy the entire `WebDev-Finals` project folder into your active XAMPP web server directory:
   ```text
   C:\xampp\htdocs\