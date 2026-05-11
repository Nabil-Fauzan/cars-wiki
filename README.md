# 🏎️ PCAR: Smart Automotive Encyclopedia & Wiki

![PCAR Banner](https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&q=80&w=1200)

**PCAR** is a premium, high-performance automotive data platform designed for enthusiasts, curators, and collectors. Built with a "Mobile-First, Data-Driven" philosophy, it combines a stunning glassmorphism aesthetic with advanced AI-assisted management.

---

## 💎 Core Pillars

### 1. Visual Excellence
Designed with a moody, dark-mode **Glassmorphism** aesthetic. Every interaction is smooth, from the dynamic radar charts for performance metrics to the tactile "machined-edge" UI components.

### 2. Admin Intelligence
Leveraging **AI Content Generation** (GPT-inspired) to automate vehicle histories, pros, and cons. Includes real-time **Data Health** monitoring and **SEO Score** automation to ensure the platform remains elite.

### 3. Enthusiast Engagement
A robust **Comparison Engine** with persistent storage, personalized **Curator Logs**, and a **Community Feedback** loop that bridges the gap between users and admins.

---

## 🔥 Key Features

### 👤 Public & User Experience
- **Smart Comparison Tray**: Save up to 3 specimens for a detailed head-to-head battle. Data persists across sessions.
- **Specimen Showroom**: High-fidelity detail pages with performance gauges, engine sound library, and marketplace insights.
- **Personal Garage**: Manage your favorite vehicles, saved comparison sets, and private curator notes.
- **Dynamic Search**: Precision filtering by Category, Horsepower, Transmission, and Brand.
- **Visual Robustness**: Global image fallback system ensuring no broken visuals.

### 🛡️ Administrative Intelligence (Filament PHP)
- **AI Magic Button**: Generate high-quality automotive content in seconds using the integrated AI generator.
- **Data Health Dashboard**: Real-time tracking of data completion, price trends, and missing assets.
- **SEO Scorecard**: Automatic SEO scoring based on content depth and metadata quality.
- **Dead Link Scanner**: Bulk maintenance tool to verify image and audio link integrity.
- **Comparison Heatmap**: Identify which vehicles are trending in the enthusiast community.
- **Security Audit Trail**: Full logging of administrative actions, changes, and access points.
- **Moderation Workflow**: Professional Draft -> Review -> Published lifecycle for all records.

---

## 🛠️ Technology Stack

- **Core**: Laravel 11 / 13
- **Admin Panel**: Filament PHP (TALL Stack)
- **Frontend**: Alpine.js, Tailwind CSS (Vanilla Logic)
- **Database**: MySQL with JSON-optimized spec handling
- **Assets**: Spatie MediaLibrary
- **Permissions**: Spatie Laravel-Permission

---

## 🚀 Quick Start

1. **Clone the repository**
2. **Install Dependencies**:
   ```bash
   composer install
   npm install && npm run build
   ```
3. **Database Setup**:
   ```bash
   php artisan migrate --seed
   ```
4. **Environment**: Ensure your `.env` is configured for MySQL.
5. **Admin Access**:
   - Access the dashboard at `/admin`
   - Default credentials (after seeding): `admin@example.com` / `password`

---

## 📈 Future Roadmap
- [ ] Integration with real-time Automotive Market APIs.
- [ ] User-driven "Battle Votes" for comparison sets.
- [ ] Advanced Audio Spectrum visualization for engine sounds.

---

*Developed with ❤️ for the Modern Automotive Collector.*
