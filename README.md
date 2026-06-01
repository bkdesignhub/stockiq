# 📦 StockIQ — Smart Inventory & Billing ERP

---

## 🚀 About StockIQ

**StockIQ** is a smart **Inventory, Billing, Wholesale, and Distributor Management ERP** built for small and medium businesses.

It helps shop owners, wholesalers, FMCG distributors, grocery stores, retail suppliers, and warehouse-based businesses manage products, stock, invoices, customers, suppliers, purchases, and sales from one simple dashboard.

> **Goal:** Replace manual notebooks and Excel stock tracking with a modern, simple, and scalable digital system.

---

## 🌐 Live Demo

🔗 **Live Website:** http://stockiq.bugy.in/

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

StockIQ is designed for businesses that buy products in bulk from manufacturers, wholesalers, or distributors and sell them to retail shops.

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

---

## 📸 Screenshots

> Add your project screenshots inside a `/screenshots` folder and replace the image paths below.

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

```bash
git clone https://github.com/bkdesignhub/stockiq.git
```

```bash
cd stockiq
```

```bash
composer install
```

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

Update your `.env` database details:

```env
DB_DATABASE=stockiq
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
php artisan migrate
```

Start development server:

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
* Distributor mobile app
* Expense tracking
* Profit and loss report
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

- [x] Inventory management
- [x] Billing workflow
- [x] Customer management
- [x] Supplier management
- [x] Purchase tracking
- [x] Sales tracking
- [ ] Barcode scanner
- [ ] WhatsApp invoice
- [ ] Advanced analytics
- [ ] SaaS multi-tenant version

---

## 👨‍💻 Developer

**Bharath Kumar**
Full Stack Laravel Developer | SaaS Product Builder | UI/UX Designer

---

## ⭐ Support

If you like this project, give it a ⭐ on GitHub.
