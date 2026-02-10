# Post Localization Guide (English & Bangla)

## Overview
This Laravel blog project now supports bilingual content for posts, allowing you to have both English and Bangla (Bengali) versions of your content. Users can switch between languages from the frontend.

## Features Added

### 1. **Database Changes**
- New Bangla fields added to the `posts` table:
  - `title_bn` - Bangla title
  - `slug_bn` - Bangla slug
  - `content_bn` - Bangla content
  - `publisher_bn` - Publisher name in Bangla
  - `reporter_bn` - Reporter name in Bangla
  - `location_bn` - Location in Bangla

### 2. **Language Switching**
- A language switcher has been added to the frontend header
- Users can switch between English and Bangla
- The selected language is stored in the session
- URL: `/locale/{locale}` where locale is either 'en' or 'bn'

### 3. **Post Model Enhancements**
The Post model now includes helper methods to get localized content:
- `getLocalizedTitle()` - Returns title based on current locale
- `getLocalizedSlug()` - Returns slug based on current locale
- `getLocalizedContent()` - Returns content based on current locale
- `getLocalizedPublisher()` - Returns publisher based on current locale
- `getLocalizedReporter()` - Returns reporter based on current locale
- `getLocalizedLocation()` - Returns location based on current locale

### 4. **Dashboard Updates**
The post creation and editing forms now have:
- Tabbed interface for English and Bangla content
- English fields are required
- Bangla fields are optional (if not provided, English content will be displayed)
- Automatic slug generation for both languages

## How to Use

### Step 1: Run the Migration
Before using the localization feature, run the migration to add Bangla fields to your database:

```bash
php artisan migrate
```

### Step 2: Creating/Editing Posts with Bangla Content

1. **Go to Dashboard** → **Posts** → **New Post** (or edit an existing post)

2. **English Tab** (Required):
   - Fill in the English title, slug, content, publisher, reporter, and location
   - These fields are mandatory

3. **Bangla Tab** (Optional):
   - Fill in the Bangla versions of the same fields
   - If you leave Bangla fields empty, the English content will be displayed when users select Bangla language

4. **Save the post** as usual

### Step 3: Frontend Language Switching

Users can switch language from the frontend:

1. **Language Switcher** is located in the header (next to the theme switcher)
2. Click on the dropdown to see available languages:
   - English
   - বাংলা (Bangla)
3. Select the desired language
4. The page will reload with content in the selected language

### Step 4: How Localization Works

**Automatic Fallback:**
- If Bangla content is not available for a post, English content is automatically displayed
- This ensures that your site always has content to display

**URL Handling:**
- Posts can be accessed using either English or Bangla slugs
- Example:
  - English: `/post/my-post-title`
  - Bangla: `/post/আমার-পোস্ট-শিরোনাম`

**Content Display:**
- When language is set to Bangla:
  - Post title, content, publisher, reporter, and location are shown in Bangla (if available)
  - Static labels like "Publisher:", "Reporter:", "Tags:", etc. are also translated

## Technical Details

### Middleware
- `SetLocale` middleware automatically sets the application locale based on session
- Added to the web middleware group in `app/Http/Kernel.php`

### Controllers
- `LocaleController` - Handles language switching
- `PostController` (Frontend) - Updated to find posts by locale-specific slugs
- `PostController` (Dashboard) - Updated to handle Bangla field validation and storage

### Routes
New route added for language switching:
```php
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
```

### Views Updated
- Dashboard: `post/add.blade.php` and `post/edit.blade.php` - Added tabbed interface
- Frontend: `post/index.blade.php` - Uses localized content
- Frontend: `components/frontend/header.blade.php` - Added language switcher

## Tips

1. **SEO Consideration**: Both English and Bangla slugs are indexed separately, which is good for SEO
2. **Content Strategy**: You don't have to translate all posts - translate only the important ones
3. **Consistency**: When adding Bangla content, make sure to add all fields (title, slug, content) for best user experience
4. **Testing**: Always test by switching languages to ensure content displays correctly

## Supported Languages

Currently supported languages:
- **English (en)** - Default language
- **বাংলা/Bangla (bn)** - Secondary language

## Future Enhancements

You can extend this localization to:
- Categories
- Tags
- Pages
- Comments
- More languages (add them in `SetLocale` middleware)

---

**Note**: The localization system is flexible and automatically falls back to English if Bangla content is not available, so you can gradually add Bangla translations to your existing posts.
