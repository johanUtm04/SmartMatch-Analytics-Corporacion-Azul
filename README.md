<h1 align="center"> SmartMatch-Analytics-Corporacion-Azul </h1>
<p align="center"> A high-performance, automated business matching and brand analytics system designed to track brand presence, monitor pricing dynamics, and map retail performance with unified intelligence. </p>

<p align="center">
  <img alt="Build" src="https://img.shields.io/badge/Build-Passing-brightgreen?style=for-the-badge">
  <img alt="Issues" src="https://img.shields.io/badge/Issues-0%20Open-blue?style=for-the-badge">
  <img alt="Contributions" src="https://img.shields.io/badge/Contributions-Welcome-orange?style=for-the-badge">
  <img alt="License" src="https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge">
</p>
<!-- 
  **Note:** These are static placeholder badges. Replace them with your project's actual badges.
  You can generate your own at https://shields.io
-->

---

### 📋 Table of Contents
- [Overview](#-overview)
- [Key Features](#-key-features)
- [Tech Stack & Architecture](#-tech-stack--architecture)
- [Project Structure](#-project-structure)
- [Environment Variables](#-environment-variables)
- [API Keys Setup](#-api-keys-setup)
- [Getting Started](#-getting-started)
- [Usage](#-usage)
- [Contributing](#-contributing)
- [License](#-license)

---

## ⭐ Overview

### Hook
**SmartMatch-Analytics-Corporacion-Azul** is an enterprise-grade analytics engine that empowers organizations to seamlessly connect and track brand ecosystems, monitor pricing variations, and evaluate overall product performance across diverse channels in real-time.

### The Problem
> Modern brand managers and retail intelligence analysts struggle with disconnected data streams. Tracking how individual products perform, monitoring dynamic pricing adjustments, and maintaining consistency within brand hierarchies across multiple environments is historically manual, prone to error, and exceptionally slow. Without a unified system to map product performance back to distinct brands, companies lose critical business insights, suffer from pricing leakage, and miss market shifts.

### The Solution
> This application solves the data fragmentation crisis by acting as a single source of truth for your brand analytics pipeline. Through automated database structures—spanning brand categorization, product indexing, point-in-time pricing histories, and unified performance metrics—the system provides a cohesive architecture to evaluate business health. Behind the scenes, the integration of optimized memory stores and cloud object delivery ensures information flows smoothly, turning raw relational data into readable, actionable performance indicators.

### Architecture Overview
The platform leverages a streamlined server-side framework powered by **PHP (Laravel)**, managing persistent application data with an expressive schema. High-performance styling and interface transitions are compiled using **Vite** coupled with **Tailwind CSS v4**, creating an ultra-lightweight and modern visual environment. The backend framework is tightly coupled with **Redis** for efficient queuing and key-value state caching, while **AWS** integration provides scalability for secure remote asset handling and cloud computational utilities.

---

## ✨ Key Features

### 🏷️ Unified Brand Ecosystem Management
Organize product directories under unified brand identities. With automated migration scripts handling brand indexes, users can classify, organize, and segment items by parent brands, facilitating comparative market share analysis without data isolation.

### 💰 Historical Pricing Auditing
Gain deep visibility into dynamic pricing fluctuations over time. The persistent historical price database tracks historical changes, allowing analytics teams to pinpoint sudden drops, track promotional anomalies, and align operational decisions with market demand.

### 📊 Granular Product Performance Trackers
Connect specific products to their concrete performance metrics. By mapping individual database keys to execution results, the platform allows you to identify top-performing units, highlight stagnating catalog entries, and execute data-driven replenishment strategies.

### ⚡ Lightning-Fast Asset Compilation
Experience optimized interfaces without long loading delays. Building on top of Vite and Tailwind CSS v4, frontend styling is compiled instantly, removing redundant CSS classes and providing highly responsive pages to client devices.

### 🔄 Multi-Driver Job Queuing
Handle resource-heavy analytical computations asynchronously. Using integrated job queues and persistent database storage, heavy report generations run cleanly in the background without affecting UI performance or database transaction integrity.

### ☁️ Scalable Infrastructure Interoperability
Benefit from enterprise-grade performance. By utilizing **Redis** cache drivers alongside **AWS** integration, the application can distribute workloads, balance memory demands, and securely store assets, keeping latency to a minimum under high database loads.

---

## 🛠️ Tech Stack & Architecture

The application's technical blueprint is structured for optimal speed, security, and low-latency rendering. Only verified dependencies and configuration strategies are implemented:

| Technology | Category | Purpose | Why it was Chosen |
| :--- | :--- | :--- | :--- |
| **PHP** | Language | Backend runtime environments | Offers reliable, robust, object-oriented framework patterns ideal for enterprise data models. |
| **Laravel** | Framework | Backend MVC orchestration | Accelerates backend development using built-in migration tools, request routing, and ORM schemas. |
| **Vite** | Build Tool | Frontend asset compilation | Replaces sluggish module bundlers to deliver instant Hot Module Replacement (HMR) during production builds. |
| **Tailwind CSS v4** | UI Styling | Utility-first responsive design | Provides an advanced design compiler natively supporting Vite configurations with minimal configuration overhead. |
| **Redis** | In-Memory Store | Caching & session storage | Drastically decreases database load times by keeping recurring system configurations cached in memory. |
| **AWS** | Cloud Provider | File storage & infrastructure | Guarantees reliable, highly-scalable storage and backend resources for distributed file management. |

---

## 📁 Project Structure

This directory map showcases the layout of the verified codebase, detailing exactly how the system separates logic, presentation, configurations, and data migrations.

```
johanUtm04-SmartMatch-Analytics-Corporacion-Azul-7d0da9b/
├── 📁 app/                             # Core Application Code
│   ├── 📁 Http/                        # HTTP Layer
│   │   └── 📁 Controllers/             # Request handlers
│   │       └── 📄 Controller.php       # Base controller class
│   ├── 📁 Models/                      # Database Eloquent Models
│   │   └── 📄 User.php                 # User authentication representation
│   └── 📁 Providers/                   # Service Providers
│       └── 📄 AppServiceProvider.php   # Application bootstrapping logic
├── 📁 bootstrap/                       # Framework Bootstrapping
│   ├── 📄 app.php                      # Application initializer
│   ├── 📄 providers.php                # Registers service providers
│   └── 📁 cache/                       # Framework generated cache
│       └── 📄 .gitignore               # Ignores cached configurations
├── 📁 config/                          # Configuration Files
│   ├── 📄 app.php                      # General application configuration
│   ├── 📄 auth.php                     # Authentication guards and providers
│   ├── 📄 cache.php                    # Cache drivers (including Redis setup)
│   ├── 📄 database.php                 # Core database connection profiles
│   ├── 📄 filesystems.php              # Remote cloud disk configurations (AWS)
│   ├── 📄 logging.php                  # Logging levels and handler routing
│   ├── 📄 mail.php                     # Outbound transactional email profiles
│   ├── 📄 queue.php                    # Background asynchronous queue configuration
│   ├── 📄 services.php                 # External third-party credentials (AWS)
│   └── 📄 session.php                  # Session driver persistence config
├── 📁 database/                        # Database Management
│   ├── 📁 factories/                   # Data generation templates
│   │   └── 📄 UserFactory.php          # Database user mock data generation
│   ├── 📁 migrations/                  # Structured SQL Schemas
│   │   ├── 📄 0001_01_01_000000_create_users_table.php             # Core authentication profile database
│   │   ├── 📄 0001_01_01_000001_create_cache_table.php             # Cache state tracking database
│   │   ├── 📄 0001_01_01_000002_create_jobs_table.php              # Background task queue database
│   │   ├── 📄 2026_06_08_184210_create_brands_table.php            # Brand indexing schema
│   │   ├── 📄 2026_06_08_184224_create_products_table.php          # Product catalog schema
│   │   ├── 📄 2026_06_08_184234_create_product_prices_table.php    # Pricing logs and audit trails
│   │   └── 📄 2026_06_08_184245_create_product_performances_table.php # Operational analytics registry
│   └── 📁 seeders/                     # Seeders for initial deployment
│       └── 📄 DatabaseSeeder.php       # Base seeder runner
├── 📁 public/                          # Server Entrypoint & Public Assets
│   ├── 📄 .htaccess                    # Apache server rewrite configurations
│   ├── 📄 favicon.ico                  # Application favorite browser icon
│   ├── 📄 index.php                    # Front controller gateway entry point
│   └── 📄 robots.txt                   # Web crawler instructions
├── 📁 resources/                       # Frontend Source Assets
│   ├── 📁 css/                         # Application Styles
│   │   └── 📄 app.css                  # Modern Tailwind CSS configuration import
│   ├── 📁 js/                          # Client-side Scripts
│   │   └── 📄 app.js                   # Application bootstrap script file
│   └── 📁 views/                       # Blade Templates
│       └── 📄 welcome.blade.php        # Initial system landing page
├── 📁 routes/                          # Application Route Mappings
│   ├── 📄 console.php                  # Custom CLI command registrations
│   └── 📄 web.php                      # Standard web interface routes
├── 📁 storage/                         # Local System Storage
│   ├── 📁 app/                         # Storage targets
│   │   ├── 📁 private/                 # Secure file uploads
│   │   └── 📁 public/                  # Exposed asset uploads
│   ├── 📁 framework/                   # Ephemeral runtime states
│   │   ├── 📁 cache/                   # File-based speed caches
│   │   ├── 📁 sessions/                # Live user session cache
│   │   ├── 📁 testing/                 # Sandboxed test utilities
│   │   └── 📁 views/                   # Compiled Blade views
│   └── 📁 logs/                        # Diagnostics Logging
│       └── 📄 .gitignore               # System error and debug log tracker
├── 📁 tests/                           # Testing Infrastructure
│   ├── 📄 TestCase.php                 # Custom assertions helper
│   ├── 📁 Feature/                     # Integration and state checks
│   │   └── 📄 ExampleTest.php          # Sample endpoint validation
│   └── 📁 Unit/                        # Isolated functional testing
│       └── 📄 ExampleTest.php          # Base operational validation
├── 📄 .editorconfig                    # IDE visual uniformity rules
├── 📄 .env.example                     # Environment template instructions
├── 📄 .gitattributes                   # Version control system behavior settings
├── 📄 .gitignore                       # Ignored build artifacts
├── 📄 .npmrc                           # Package manager configuration
├── 📄 artisan                          # Laravel Command Line interface tool
├── 📄 composer.json                    # PHP Package dependencies and config
├── 📄 composer.lock                    # Locked PHP Dependency versions
├── 📄 package.json                     # Frontend build runner configs
├── 📄 phpunit.xml                      # Automated testing settings
├── 📄 README.md                        # Project documentation file
└── 📄 vite.config.js                   # Vite builder integration settings
```

---

## 🔐 Environment Variables

The application utilizes a secure environment file to define variable drivers and deployment profiles. Ensure these values match your infrastructure profile prior to starting the application:

| Variable Name | Required | Example Value | Purpose & Usage |
| :--- | :--- | :--- | :--- |
| `APP_NAME` | Yes | `SmartMatch-Analytics` | Defines the branding output in dashboard headers and automated communications. |
| `APP_ENV` | Yes | `production` / `local` | Governs strict security policies, debug details, and development console features. |
| `APP_KEY` | Yes | `base64:uqX1...` | Secret key used for cryptographic hashes, user session cookies, and encrypted tokens. |
| `APP_DEBUG` | Yes | `false` | Instructs the framework to suppress execution details during active client errors. |
| `APP_URL` | Yes | `https://analytics.corp-azul.com` | Base URL used to format hyperlinked assets, system routing, and callback endpoints. |
| `APP_LOCALE` | No | `es` | Core user interface language code. |
| `APP_FALLBACK_LOCALE` | No | `en` | Backup language target if primary localized translations are missing. |
| `APP_FAKER_LOCALE` | No | `es_ES` | Directs mock seed factories to output geographically appropriate user data. |
| `APP_MAINTENANCE_DRIVER` | No | `file` | Controls state tracking for system-wide service maintenance. |
| `BCRYPT_ROUNDS` | No | `12` | Cryptographic complexity control factor when generating secure credentials. |

---

## 🔑 API Keys Setup

To fully run analytics jobs and handle data files, external configurations must be configured within your `.env` workspace.

### 📌 Redis Connection Setup
To use key caching or run async workers, configure the connection block in your active `.env`:
1. Obtain your secure Redis endpoint host, port, and authentication credentials.
2. In your local `.env`, configure the caching drivers:
   ```env
   CACHE_STORE=redis
   QUEUE_CONNECTION=redis
   REDIS_HOST=your-redis-server-endpoint.com
   REDIS_PASSWORD=your_highly_secure_redis_password
   REDIS_PORT=6379
   ```

### 📌 AWS Integration Setup
Secure asset upload pipelines depend on AWS credentials configured in your backend settings:
1. Access your AWS Console and open the Identity and Access Management (IAM) control panel.
2. Generate an Access Key ID with secure read/write policies for AWS S3.
3. Add the following parameters to your `.env` configuration file:
   ```env
   AWS_ACCESS_KEY_ID=AKIAIOSFODNN7EXAMPLE
   AWS_SECRET_ACCESS_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY
   AWS_DEFAULT_REGION=us-east-1
   AWS_BUCKET=smartmatch-analytics-bucket
   AWS_USE_PATH_STYLE_ENDPOINT=false
   ```

---

## 🚀 Getting Started

Follow this sequence to clone, configure, run migrations, and launch your copy of the application.

### Prerequisites
Before installation, verify your hosting environment includes these software dependencies:
- **PHP**: version `^8.2` or newer
- **Composer**: PHP Dependency Manager
- **NodeJS**: version `^18.x` or newer (accompanied by **npm**)

---

### Step-by-Step Installation

#### 1. Obtain the Project Source Code
Download the repository files to your local environment:
```bash
git clone https://github.com/your-org/SmartMatch-Analytics-Corporacion-Azul.git
cd SmartMatch-Analytics-Corporacion-Azul
```

#### 2. Install PHP Package Dependencies
Retrieve the framework backend files using Composer:
```bash
composer install --no-dev --optimize-autoloader
```
*(Remove `--no-dev` if you intend to configure local testing tools and run standard tests.)*

#### 3. Install Frontend Dependencies
Download package managers defined in the node registry:
```bash
npm install
```

#### 4. Configure Application Environment Keys
Copy the configuration template to generate your local parameters file:
```bash
cp .env.example .env
```
Once copied, open `.env` in your editor and configure your database settings, connection variables, Redis details, and AWS settings.

#### 5. Generate Application Key
Initialize your encryption secret key:
```bash
php artisan key:generate
```

#### 6. Run Database Migrations
Execute structural schema deployments to define tables for users, caches, jobs, brands, products, prices, and performance:
```bash
php artisan migrate --force
```
*(The `--force` option is recommended for production profiles to execute updates without prompts).*

#### 7. Build Frontend Static Assets
Process styles and client script libraries:
```bash
# Compile and optimize assets for deployment
npm run build

# Alternatively, run a local hot reloading dev server
npm run dev
```

#### 8. Start the Local Server
Boot up the PHP development environment:
```bash
php artisan serve
```
Open your browser and navigate to `http://localhost:8000` to interact with the web dashboard.

---

## 🔧 Usage

Operating the analytics application is designed to be frictionless. Ensure you execute key management actions to keep analytics flowing smoothly:

### Running Database Migrations
To clean, drop, and seed the entire brand, product, and analytics structure (ideal for sandboxed local environments):
```bash
php artisan migrate:fresh --seed
```

### Running Background Queues
Because data processing, brand matching, and performance calculation tasks execute asynchronously using the queue engine, start a worker process using Artisan:
```bash
php artisan queue:work --queue=default
```

### Running Unit and Integration Tests
To execute automated verification assertions against system models and controllers:
```bash
# Run tests using automated PHPUnit configurations
php artisan test
```

---

## 🤝 Contributing

We welcome contributions to improve SmartMatch-Analytics-Corporacion-Azul! Your input helps make this project better for everyone.

### How to Contribute

1. **Fork the repository** - Click the 'Fork' button at the top right of this page
2. **Create a feature branch** 
   ```bash
   git checkout -b feature/amazing-feature
   ```
3. **Make your changes** - Improve code, documentation, or features
4. **Test thoroughly** - Ensure all functionality works as expected
   ```bash
   php artisan test
   ```
5. **Commit your changes** - Write clear, descriptive commit messages
   ```bash
   git commit -m 'Add: Amazing new feature that does X'
   ```
6. **Push to your branch**
   ```bash
   git push origin feature/amazing-feature
   ```
7. **Open a Pull Request** - Submit your changes for review

### Development Guidelines

- ✅ Follow the existing code style and PSR-12 formatting conventions.
- 📝 Add comments for complex logic and database schema relations.
- 🧪 Write tests for new analytical features and bug fixes.
- 📚 Update documentation for any changed functionality.
- 🔄 Ensure database schema modifications are safely backwards-compatible.
- 🎯 Keep commits focused and descriptive.

### Ideas for Contributions

We're looking for help with:

- 🐛 **Bug Fixes:** Report and resolve backend anomalies or migration issues.
- ✨ **New Features:** Implement advanced analytical reports.
- 📖 **Documentation:** Improve installation guides, rewrite code annotations, and add tutorials.
- 🎨 **UI/UX:** Enhance interface layouts using Tailwind CSS utilities.
- ⚡ **Performance:** Optimize Eloquent queries to retrieve metrics faster.
- 🧪 **Testing:** Expand unit tests to improve code coverage.

### Code Review Process

- All submissions require review by maintainers before merging.
- Reviewers will provide constructive feedback on structure, formatting, and performance.
- Adjustments may be requested before final approval.
- Once approved, your PR will be integrated, and you'll be credited in the changelog!

---

## 📝 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for complete details.

### What this means:

- ✅ **Commercial use:** You can use this project commercially.
- ✅ **Modification:** You can modify the code.
- ✅ **Distribution:** You can distribute this software.
- ✅ **Private use:** You can use this project privately.
- ⚠️ **Liability:** The software is provided "as is", without warranty of any kind.
- ⚠️ **Trademark:** This license does not grant trademark rights.

---

<p align="center">Made with ❤️ by the Corporacion Azul Analytics Team</p>
<p align="center">
  <a href="#">⬆️ Back to Top</a>
</p>