# 📦 StockIQ — Smart Inventory & Billing ERP

---

## 🚀 About StockIQ

**StockIQ** is a smart **Inventory, Billing, Wholesale, and Distributor Management ERP** built for small and medium-sized businesses.

It helps shop owners, wholesalers, FMCG distributors, grocery stores, retail suppliers, and warehouse-based businesses manage products, inventory, invoices, customers, suppliers, purchases, and sales from a single dashboard.

> **Goal:** Replace manual notebooks and Excel-based stock tracking with a modern, scalable, and easy-to-use digital inventory management solution.

---

## 🌐 Live Demo

🔗 **Live Website:** http://stockiq.bugy.in/

🔗 **GitHub Repository:** https://github.com/bkdesignhub/stockiq

---

## ✨ Key Features

### 📦 Inventory Management

* Product stock management
* Low stock alerts
* Category-wise product organization
* Stock in / stock out tracking
* Warehouse-based inventory control

### 🧾 Billing & Invoice System

* Quick invoice generation
* Customer billing records
* GST-ready billing structure
* Printable invoice format
* Sales history tracking

### 🛒 Purchase Management

* Supplier purchase entries
* Purchase history
* Product cost tracking
* Supplier-wise purchase reports

### 👥 Customer & Supplier Management

* Customer database
* Supplier database
* Contact and billing details
* Purchase and sales relationship tracking

### 📊 Dashboard & Reports

* Total sales overview
* Total purchase overview
* Stock summary
* Low stock products
* Revenue and business insights

### 🏪 Best For

* Grocery stores
* FMCG wholesalers
* Retail distributors
* Small warehouses
* Medical and personal care distributors
* Department stores
* Supermarkets
* Local wholesale businesses

---

## 🧠 Business Use Case

StockIQ is designed for businesses that purchase products in bulk from manufacturers, wholesalers, or distributors and sell them to retail shops.

Example workflow:

```text
Manufacturer / Main Wholesaler
        ↓
Distributor / StockIQ User
        ↓
Retail Shops / Grocery Stores / Medical Shops
        ↓
Invoice + Stock Update + Report
```

---

## 🛠 Tech Stack

* Laravel
* PHP
* MySQL
* Blade Templates
* Bootstrap
* JavaScript
* HTML5 & CSS3

---

## 📸 Screenshots

<p align="center">
  <img src="https://raw.githubusercontent.com/bkdesignhub/stockiq/main/Screenshot%202026-06-01%20115358.png" width="900" alt="StockIQ Dashboard Screenshot">
</p>

### Dashboard Overview

The following screenshot showcases the StockIQ dashboard interface, providing a complete overview of inventory, sales, purchases, and business operations.

---

## 📁 Suggested Project Structure

```text
stockiq/
├── app/
│   ├── Http/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── public/
├── screenshots/
└── README.md
```

---

## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/bkdesignhub/stockiq.git
```

Navigate to the project directory:

```bash
cd stockiq
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Update your `.env` database configuration:

```env
DB_DATABASE=stockiq
DB_USERNAME=root
DB_PASSWORD=
```

Run database migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

---

## 🔐 Admin Modules

```text
✅ Dashboard
✅ Products
✅ Categories
✅ Stock Management
✅ Customers
✅ Suppliers
✅ Purchases
✅ Sales
✅ Billing
✅ Reports
✅ Settings
```

---

## 📈 Future Upgrade Ideas

* Barcode scanning
* GST invoice export
* WhatsApp invoice sharing
* Multi-warehouse support
* Retail shop order portal
* Distributor mobile application
* Expense tracking
* Profit and loss reporting
* Role-based staff access
* SaaS subscription version

---

## 📌 Product Roadmap

### ✅ Completed

* Inventory Management
* Product & Category Management
* Stock In / Stock Out Tracking
* Customer Management
* Supplier Management
* Purchase Management
* Sales Management
* Billing & Invoice Generation
* Dashboard & Business Overview
* Basic Reports & Analytics

### 🚧 In Progress

* Enhanced Sales Reports
* Low Stock Notifications
* Improved Invoice Printing Layout
* Performance Optimization

### 🔜 Upcoming Features

* Barcode & QR Code Scanning
* GST-Compliant Invoice Export
* WhatsApp Invoice Sharing
* Multi-Warehouse Management
* Role-Based User Access Control
* Expense Management Module
* Profit & Loss Reporting
* Advanced Inventory Analytics
* Customer Credit & Payment Tracking
* Mobile Responsive Enhancements

### 🎯 Long-Term Vision

* Mobile Application (Android & iOS)
* SaaS Multi-Tenant Version
* Distributor & Retailer Order Portal
* API Integrations
* E-commerce Integration
* AI-Based Demand Forecasting
* Automated Reorder Suggestions
* Cloud Backup & Data Synchronization

### Progress Checklist

* [x] Inventory Management
* [x] Billing Workflow
* [x] Customer Management
* [x] Supplier Management
* [x] Purchase Tracking
* [x] Sales Tracking
* [ ] Barcode Scanner
* [ ] WhatsApp Invoice Integration
* [ ] Advanced Analytics
* [ ] SaaS Multi-Tenant Version

---

## 👨‍💻 Developer

**Bharath Kumar**
Full Stack Laravel Developer | SaaS Product Builder | UI/UX Designer

🌐 Portfolio: https://bugy.in/

📧 Email: [bkdesigner0@gmail.com](mailto:bkdesigner0@gmail.com)

🐙 GitHub: https://github.com/bkdesignhub

---

## ⭐ Support

If you like this project, please consider giving it a ⭐ on GitHub and sharing it with others.

Thank you for supporting **StockIQ**! 🚀
