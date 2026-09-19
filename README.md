# Portfolio — Randi Mulyana

Personal portfolio web built with **Laravel 11** + **Tailwind CSS (CDN)**, designed mobile-first, dark/light themed, and SEO-ready.

## ✨ Features

- 🏠 **Home** — hero, about, skills, featured projects, experience
- 👤 **About** — bio, photo, resume
- 💼 **Projects index** — filter by tech, paginated
- 🔍 **Project detail** — full description, tech stack, live/repo links, related projects
- ✉️ **Contact** — form with server-side validation, stored to `messages` table
- 🌗 **Dark / Light mode** — persisted in `localStorage`, respects `prefers-color-scheme`, no flash on load
- 📱 **Fully responsive** — mobile burger menu, fluid typography, touch-friendly
- 🧭 **SEO** — semantic meta tags, OpenGraph, Twitter card, JSON-LD (Person + CreativeWork), canonical URL
- 🗺️ **Sitemap** — `/sitemap.xml` (auto-generated from DB)
- 🤖 **robots.txt** — allows all + points to sitemap

## 🛠️ Tech stack

- **Backend:** Laravel 11, PHP 8.3+
- **Database:** SQLite (default), MySQL/Postgres compatible
- **Frontend:** Tailwind CSS v3 (CDN), vanilla JS (no build step)
- **Server:** Any PHP-capable host (Termux, shared hosting, Forge, Vapor, etc.)

## 🚀 Quick start

```bash
# 1. Install dependencies
composer install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Database (SQLite)
touch database/database.sqlite
php artisan migrate --seed

# 4. Serve
php artisan serve --host=0.0.0.0 --port=8000
```

Then open: `http://localhost:8000`

For LAN access from phone: `http://<your-ip>:8000`

## 📁 Project structure

```
app/
  Http/Controllers/
    PortfolioController.php    # home, about, projects, contact
    SitemapController.php      # /sitemap.xml
  Models/
    Profile.php                # single-row identity
    Project.php                # portfolio projects
    Skill.php
    Experience.php
    Message.php                # contact submissions
database/
  migrations/
  seeders/
    DatabaseSeeder.php
    ProfileSeeder.php
    ProjectSeeder.php
    SkillSeeder.php
    ExperienceSeeder.php
resources/views/
  portfolio/
    layout.blade.php           # main layout (theme + nav)
    home.blade.php
    about.blade.php
    projects/
      index.blade.php
    project.blade.php          # project detail
    contact.blade.php
  sitemap.xml                  # sitemap template
public/
  robots.txt
  .htaccess
routes/
  web.php
```

## 🗃️ Database schema

| Table        | Purpose                                    |
|--------------|--------------------------------------------|
| `profiles`   | Single row: name, title, bio, socials      |
| `projects`   | Slug, title, description, tech_stack (JSON), cover, live_url, repo_url, is_featured, is_published, published_at |
| `skills`     | name, category, proficiency                |
| `experiences`| company, role, start/end, is_current, description |
| `messages`   | Contact form submissions                   |

## 🎨 Customization

### Change theme colors
Edit CSS variables in `resources/views/portfolio/layout.blade.php`:
```css
:root { --bg: #f8fafc; --text: #0f172a; --gradient: linear-gradient(90deg,#6366f1,#ec4899); }
html.dark { --bg: #020617; --text: #f1f5f9; }
```

### Add your info
Edit `database/seeders/ProfileSeeder.php` then re-seed:
```bash
php artisan migrate:fresh --seed
```

Or update via tinker:
```bash
php artisan tinker
>>> App\Models\Profile::first()->update(['name' => 'Your Name']);
```

## 🌐 SEO checklist

- ✅ `<title>` and `<meta description>` per page
- ✅ OpenGraph + Twitter Card tags
- ✅ JSON-LD structured data (Person on home, CreativeWork on projects)
- ✅ Canonical URL
- ✅ `robots.txt` (allows all + sitemap)
- ✅ `sitemap.xml` (auto-generated)
- ✅ Semantic HTML (`<header>`, `<main>`, `<article>`, `<nav>`, `<footer>`)
- ✅ Mobile-friendly + responsive
- ✅ Fast (no build step, single page loads, Tailwind via CDN)

## 📜 License

MIT — feel free to fork and adapt.
