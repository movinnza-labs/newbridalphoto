# The Bridal Photography — CodeIgniter 4.7 Website

**Framework:** CodeIgniter **4.7** (PHP 8.2+)  
**Design:** Editorial Luxury — warm white/cream balanced with selective dark sections  
**Blog:** Dynamic CMS with admin panel + TinyMCE editor  
**URLs:** SEO-friendly with trailing slashes, no `.html` or `index.php`

---

## Quick Start (5 steps)

### Step 1 — Install dependencies
```bash
composer install
```
This downloads CI4.7 framework into `vendor/`. The `composer.json` pins `"codeigniter4/framework": "^4.7"`.

### Step 2 — Create your `.env` file
```bash
cp env.example .env
```
Then edit `.env` and set at minimum:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'https://thebridal.photography/'
app.indexPage = ''

database.default.hostname = localhost
database.default.database = thebridal_db
database.default.username = thebridal_user
database.default.password = YOUR_PASSWORD_HERE
database.default.DBDriver = MySQLi
database.default.DBPrefix = tb_
```

### Step 3 — Generate encryption key
```bash
php spark key:generate
```

### Step 4 — Run database migration
```bash
php spark migrate
```
Creates the `tb_blogs` table.

### Step 5 — Point web server to `/public/`

**Apache VirtualHost:**
```apache
<VirtualHost *:80>
    ServerName thebridal.photography
    DocumentRoot /path/to/thebridal-ci4/public
    <Directory /path/to/thebridal-ci4/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx:**
```nginx
server {
    server_name thebridal.photography;
    root /path/to/thebridal-ci4/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }
}
```

---

## Project Structure

```
thebridal-ci4/
├── app/
│   ├── Config/
│   │   ├── App.php          ← Set baseURL here (or via .env)
│   │   ├── Database.php     ← DB credentials (or via .env)
│   │   ├── Paths.php        ← CI4 standard paths (do not edit)
│   │   ├── Routes.php       ← All SEO URLs with trailing slashes ✓
│   │   └── [35 other CI4 config files - from official appstarter]
│   │
│   ├── Controllers/
│   │   ├── BaseController.php   ← CI4 4.7 compatible
│   │   ├── Home.php             ← Homepage
│   │   ├── Pages.php            ← All 15 static service pages
│   │   ├── CityHub.php          ← Mumbai + Ahilyanagar city pages
│   │   ├── Blog.php             ← Public blog listing + detail
│   │   └── Admin/
│   │       ├── Dashboard.php    ← Admin dashboard
│   │       └── Blogs.php        ← Full CRUD + image upload
│   │
│   ├── Models/
│   │   └── BlogModel.php        ← Slug auto-gen, related posts, view count
│   │
│   ├── Views/
│   │   ├── layouts/main.php     ← Master layout (JSON-LD, OG tags, fonts)
│   │   ├── partials/
│   │   │   ├── header.php       ← Shared nav — edit once, reflects everywhere
│   │   │   ├── footer.php       ← Shared footer
│   │   │   └── breadcrumb.php
│   │   ├── pages/               ← 28 static page views
│   │   │   ├── home.php
│   │   │   ├── wedding-packages.php
│   │   │   ├── maternity-photographer.php
│   │   │   ├── engagement-packages.php
│   │   │   └── city/            ← 11 city sub-pages
│   │   ├── blog/
│   │   │   ├── index.php        ← Listing with filter tabs + pagination
│   │   │   └── detail.php       ← Full article + sidebar + related posts
│   │   ├── admin/
│   │   │   ├── dashboard.php
│   │   │   ├── blog/
│   │   │   │   ├── index.php    ← Manage all posts
│   │   │   │   └── form.php     ← Create/edit with TinyMCE 6
│   │   │   └── partials/sidebar.php
│   │   └── errors/              ← CI4 standard error pages
│   │
│   └── Database/Migrations/
│       └── CreateBlogsTable.php
│
├── public/               ← WEB SERVER DOCUMENT ROOT
│   ├── index.php         ← CI4 4.7 front controller (Boot::bootWeb)
│   ├── .htaccess         ← Trailing slash enforce + clean URLs + security
│   ├── css/main.css      ← Full design system (white/cream/warm theme)
│   ├── js/main.js        ← Nav, FAQ accordion, blog filter, lazy load
│   └── img/
│       ├── pages/        ← Static page images (SEO-named)
│       └── blog/         ← Blog images uploaded via admin
│
├── writable/             ← Must be writable by web server (chmod 755)
│   ├── cache/
│   ├── logs/
│   ├── session/
│   └── uploads/
│
├── composer.json         ← "codeigniter4/framework": "^4.7", php "^8.2"
├── env.example           ← Copy to .env and configure
├── spark                 ← CI4 CLI (php spark migrate, php spark key:generate)
└── README.md
```

---

## URL Map

| URL | Controller::method |
|-----|--------------------|
| `/` | `Home::index` |
| `/pre-wedding-shoot/` | `Pages::preWeddingLocations` |
| `/pre-wedding-photography-packages/` | `Pages::preWeddingPackages` |
| `/pre-wedding-shoot-pune-under-10000/` | `Pages::preWeddingBudget` |
| `/pre-wedding-shoot-satara/` | `Pages::preWeddingSatara` |
| `/when-to-take-pre-wedding-shoot/` | `Pages::whenPreWedding` |
| `/pre-wedding-shoot-locations-in-goa/` | `Pages::preWeddingGoa` |
| `/pre-wedding-shoot-locations-mumbai/` | `Pages::preWeddingMumbai` |
| `/wedding-photography-packages/` | `Pages::weddingPackages` |
| `/engagement-photography-packages/` | `Pages::engagementPackages` |
| `/roka-ring-ceremony-photography-pune/` | `Pages::rokaPackages` |
| `/maternity-photographer-pune/` | `Pages::maternityPhotographer` |
| `/maternity-photoshoot-locations-pune/` | `Pages::maternityLocations` |
| `/baby-shower-photography-packages/` | `Pages::babyShowerPackages` |
| `/baby-photoshoot-pune/` | `Pages::babyPhotoshoot` |
| `/wedding-films/` | `Pages::weddingFilms` |
| `/services/` | `Pages::services` |
| `/faq/` | `Pages::faq` |
| `/fashion-and-product-photography/` | `Pages::productPhotography` |
| `/mumbai/` | `CityHub::mumbai` |
| `/mumbai/engagement-photography-packages/` | `CityHub::mumbaiEngagement` |
| `/mumbai/pre-wedding-shoot/` | `CityHub::mumbaiPreWedding` |
| `/mumbai/wedding-photographers/` | `CityHub::mumbaiWedding` |
| `/ahilyanagar/` | `CityHub::ahilyanagar` |
| `/ahilyanagar/pre-wedding-shoot/` | `CityHub::ahilyanagaPreWedding` |
| `/ahilyanagar/wedding-photographers/` | `CityHub::ahilyanagaWedding` |
| `/ahilyanagar/engagement-photographers/` | `CityHub::ahilyanagaEngagement` |
| `/ahilyanagar/maternity-photographer/` | `CityHub::ahilyanagaMaternity` |
| `/ahilyanagar/baby-photoshoot/` | `CityHub::ahilyanagaBaby` |
| `/ahilyanagar/corporate-event-meeting-shoot/` | `CityHub::ahilyanagaCorporate` |
| `/blog/` | `Blog::index` |
| `/blog/{slug}/` | `Blog::detail` |
| `/admin/` | `Admin\Dashboard::index` |
| `/admin/blogs/` | `Admin\Blogs::index` |
| `/admin/blogs/create/` | `Admin\Blogs::create` |
| `/admin/blogs/store/` | `Admin\Blogs::store` (POST) |
| `/admin/blogs/edit/{id}/` | `Admin\Blogs::edit` |
| `/admin/blogs/update/{id}/` | `Admin\Blogs::update` (POST) |
| `/admin/blogs/delete/{id}/` | `Admin\Blogs::delete` (POST) |

---

## Admin Panel — Blog CMS

Access: `https://thebridal.photography/admin/`

**Features:**
- Create / Edit / Delete blog posts
- TinyMCE 6 rich text editor with image upload
- SEO fields: meta title, meta description (with character counters)
- Category, tags, featured image upload (auto SEO-named)
- Publish status: Draft / Published / Archived
- Featured post toggle (hero slot on blog listing)
- View count tracking

**⚠️ Add authentication before go-live:**
```bash
composer require codeigniter4/shield
php spark shield:setup
```
Then add `['filter' => 'session']` to all `/admin/` routes.

---

## Design System

**Color palette** (`public/css/main.css` CSS variables):

| Variable | Value | Usage |
|----------|-------|-------|
| `--bg-white` | `#FFFFFF` | Primary page backgrounds |
| `--bg-off` | `#FAF8F4` | Alternating sections |
| `--bg-warm` | `#F5EFE6` | CTA areas, related links |
| `--bg-cream` | `#EDE4D6` | Testimonials |
| `--bg-dark` | `#0D0B09` | Footer, admin sidebar |
| `--gold` | `#C9A96E` | Primary accent throughout |
| `--text-primary` | `#1C1612` | Headings |
| `--text-body` | `#3D3028` | Body text |
| `--text-muted` | `#7A6654` | Secondary text |

**Fonts:** Playfair Display (display/serif) + Jost (body/sans)

---

## Security Checklist (Before Go-Live)

- [ ] `composer require codeigniter4/shield` + protect `/admin/` routes
- [ ] Set `CI_ENVIRONMENT = production` in `.env`
- [ ] Uncomment HTTPS redirect in `public/.htaccess`
- [ ] Run `php spark key:generate` (sets `encryption.key`)
- [ ] Set `app.baseURL` to live domain in `.env`
- [ ] `chmod 755 writable/` and `chmod 755 public/img/`
- [ ] Use a dedicated MySQL user with only SELECT/INSERT/UPDATE/DELETE on `thebridal_db`
- [ ] Configure server-side automated backups for DB + `writable/uploads/`

---

## Image Migration

Currently images point to the live WordPress CDN (`thebridal.photography/wp-content/uploads/`).  
To use local images after migration:

1. Download images into `public/img/pages/` with SEO-friendly names
2. Update `$WP` variable at the top of each view file:
   ```php
   // Change from:
   $WP = 'https://thebridal.photography/wp-content/uploads';
   // To:
   $WP = base_url('img/pages');
   ```

Optimize after download:
```bash
find public/img -name "*.jpg" -exec mogrify -resize 1920x\> -quality 85 {} \;
```
