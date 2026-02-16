# Bengali (bn) Default Language Implementation

## ✅ Completed Setup

### 1. **Configuration Files**
- **config/app.php**
  - `locale: 'bn'` - Bengali set as default application locale
  - `fallback_locale: 'en'` - English as fallback when Bengali content is unavailable
  
- **.env**
  - `APP_LOCALE=bn` - Environment variable configured for Bengali default

### 2. **Service Provider**
- **app/Providers/AppServiceProvider.php**
  - `App::setLocale('bn')` called in boot() method to ensure Bengali is set on every request

### 3. **Middleware**
- **app/Http/Middleware/SetLocale.php**
  - Registered in web middleware group (app/Http/Kernel.php)
  - Checks session for user's language preference
  - Falls back to `config('app.locale')` which is 'bn'
  - Validates locale against available locales ['en', 'bn']

### 4. **Routing**
- **routes/web.php**
  - `Route::get('/locale/{locale}', [LocaleController::class, 'switch'])` - Locale switcher route configured
  - LocaleController properly handles language switching and stores in session

### 5. **Language Files**
- **resources/lang/en/messages.php** - English translations
- **resources/lang/bn/messages.php** - Bengali translations

  Translation files include:
  - Frontend labels (Dashboard, Home, Search, etc.)
  - Post-related terms (Posts, Categories, Tags, etc.)
  - Authentication labels (Login, Register, etc.)
  - Form inputs and buttons

### 6. **Post Model Localization**
- **app/Models/Post.php**
  - Bilingual fields: `title_bn`, `slug_bn`, `content_bn`, `publisher_bn`, `reporter_bn`, `location_bn`
  - Helper methods:
    - `getLocalizedTitle()` - Returns Bengali title if available, else English
    - `getLocalizedSlug()` - Returns Bengali slug if available, else English
    - `getLocalizedContent()` - Returns Bengali content if available, else English
    - `getLocalizedPublisher()` - Returns Bengali publisher if available, else English
    - `getLocalizedReporter()` - Returns Bengali reporter if available, else English
    - `getLocalizedLocation()` - Returns Bengali location if available, else English
    - `getLocalizedCreatedAt()` - Returns date in Bengali format when locale is 'bn'

### 7. **Frontend Language Switcher**
- **resources/views/components/frontend/header.blade.php**
  - Language dropdown selector in header
  - Shows current language (বাংলা or English)
  - Allows switching between English and Bangla

## 🚀 How It Works

1. **On First Load**:
   - User visits the site
   - SetLocale middleware checks session for 'locale'
   - If not in session, uses `config('app.locale')` which is 'bn' (Bengali)
   - Page loads in Bengali

2. **When User Switches Language**:
   - User clicks language switcher in header
   - Routes to `/locale/{locale}` endpoint
   - LocaleController stores selected locale in session
   - Redirects back to previous page
   - Next request uses the new locale from session
   - If Bengali content not available for a post, English content is displayed (fallback)

3. **Content Display**:
   - Post model methods like `getLocalizedTitle()` automatically return:
     - Bengali version if available and locale is 'bn'
     - English version as fallback

## 📝 Available Languages
- `en` - English
- `bn` - Bengali (বাংলা)

## 📁 Directory Structure
```
resources/
├── lang/
│   ├── en/
│   │   └── messages.php      # English translations
│   └── bn/
│       └── messages.php      # Bengali translations
└── views/
    ├── components/frontend/
    │   └── header.blade.php   # Language switcher
    └── ...
```

## 🔧 Using Translations in Views

To use translations in your Blade templates:

```blade
{{ __('messages.dashboard') }}          <!-- Shows 'Dashboard' or 'ড্যাশবোর্ড' -->
{{ __('messages.posts') }}              <!-- Shows 'Posts' or 'পোস্টসমূহ' -->
```

## ✨ Default Behavior
- **Default Language**: Bengali (bn)
- **Fallback Language**: English (en)
- **User Preference**: Stored in session
- **Persistence**: Session-based (resets on logout/new browser session)

## 📚 Available Translation Keys

### Frontend
- dashboard, home, search, read_more, share, comment, comments, no_comments, leave_comment, your_comment, your_name, your_email, submit, cancel, delete, edit, add, save, update, back

### Posts
- posts, post, new_post, edit_post, delete_post, title, content, category, tags, featured, publish, published, draft, author, date, views, reading_time, publisher, reporter, location

### Categories
- categories, new_category, edit_category, category_name

### Authentication
- login, logout, register, email, password, confirm_password, remember_me, forgot_password

### Pagination
- first, last, previous, next

