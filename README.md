# 👑 Golden Queen Management System

Golden Queen is a Laravel QR-powered restaurant platform that offers mobile-first ordering, menu browsing, and feedback collection — built with elegance, precision, and purpose.

## ✨ Features

- 📱 Responsive public menu view with mobile-friendly layout
- 🖼️ QR code generation (SVG & PNG) for seamless ordering
- ✍️ Customer order form with table assignment and review
- 🔐 Role-based access for Admin, Worker, and Customer users
- 🧮 Inventory management with visual dashboards
- 📊 CSV export functionality for user and order data
- 🕒 Last login tracking for authenticated users
- 🧾 Admin panel for managing feedback, users, and menu items

## 🚀 Tech Stack

- Laravel 10
- Laravel Breeze (Authentication scaffolding)
- Tailwind CSS
- Blade Templates
- FontAwesome & Heroicons
- Simple QrCode (via SimpleSoftwareIO)
- MySQL

## 🧪 Setup Instructions

```bash
# Clone the repo
git clone https://github.com/Willy-Akampurira/golden-queen-management-system.git
cd golden-queen-management-system

# Install dependencies
composer install
npm install && npm run dev

# Configure environment
cp .env.example .env
php artisan key:generate

# Migrate database & seed starter data
php artisan migrate --seed

# Launch locally
php artisan serve

## 📸 Screenshots

### 🧭 Public Menu
- ![Login Form](screenshots/PublicMenu/login_form.png)
- ![Register Form](screenshots/PublicMenu/register_form.png)
- ![Welcome Page](screenshots/PublicMenu/public_welcome_page.png)
- ![Mobile Menu Layout](screenshots/PublicMenu/public_menu.png)
- ![Order Form](screenshots/PublicMenu/order_form.png)
- ![Leave Reviews](screenshots/PublicMenu/reviews_form.png)

### 🧑‍💼 Admin Panel
- ![Admin Dashboard](screenshots/Admin/admin_dashboard.png)
- ![Admin Menu Items](screenshots/Admin/admin_menu_items.png)
- ![Admin Menu Items](screenshots/Admin/admin_add_menu_item.png)
- ![Admin Menu Items](screenshots/Admin/admin_edit_menu_item.png)
- ![Admin Menu Items](screenshots/Admin/admin_trashed_menu_items.png)
- ![Admin Orders](screenshots/Admin/admin_orders.png)
- ![Admin Orders](screenshots/Admin/Admin_orders_actions.png)
- ![User Management Table](screenshots/Admin/admin_users.png)
- ![User Management Table](screenshots/Admin/admin_add_new_user.png)
- ![User Management Table](screenshots/Admin/admin_edit_user.png)
- ![User Management Table](screenshots/Admin/admin_trashed_users.png)
- ![Feedback Review](screenshots/Admin/admin_customer_feedback.png)
- ![Feedback Review](screenshots/Admin/admin_feedback_reply.png)
- ![Inventory Items](screenshots/Admin/admin_inventory_items.png)
- ![Inventory Items](screenshots/Admin/admin_add_new_inventory_item.png)
- ![Inventory Items](screenshots/Admin/admin_edit_inventory_item.png)
- ![Inventory Items](screenshots/Admin/admin_trashed_inventory_items.png)
- ![Inventory Dashboard](screenshots/Admin/admin_inventory_dashboard.png)
- ![Inventory Transactions](screenshots/Admin/admin_inventory_transactions.png)
- ![Inventory Transactions](screenshots/Admin/admin_log_inventory_transaction.png)

### 👷 Worker Dashboard
- ![Worker Task Overview](screenshots/Worker/worker_dashboard_1.png)
- ![Order Processing View](screenshots/Worker/worker_dashboard.png)

### 🧍 Customer Profile
- ![Customer Dashboard](screenshots/Customer/customer_dashboard.png)
- ![Customer Profile](screenshots/Customer/customer_profile.png)
- ![Customer Profile](screenshots/Customer/customer_profile_1.png)

### 🖼️ QR Code Management
- ![QR View & Scan](screenshots/QRCode/qr_code.png)


