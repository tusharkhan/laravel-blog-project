# New Post Fields Implementation - Publisher, Reporter, Location

## Overview
Added three new optional fields to the Post model: Publisher, Reporter, and Location. These fields allow better categorization and tracking of blog post information.

## Changes Made

### 1. Database Migration
**File**: `database/migrations/2026_02_07_000001_add_fields_to_posts_table.php`

Creates three nullable string columns in the `posts` table:
- `publisher` - Publisher name (nullable)
- `reporter` - Reporter name (nullable) 
- `location` - Location information (nullable)

**To apply migration:**
```bash
php artisan migrate
```

### 2. Post Model Update
**File**: `app/Models/Post.php`

Added three new fields to the `$fillable` array:
```php
protected $fillable = [
    // ...existing fields...
    "publisher",
    "reporter",
    "location",
];
```

### 3. Dashboard - Add Post View
**File**: `resources/views/dashboard/post/add.blade.php`

Added three new form fields after the Status field:
- **Publisher field**: Text input for publisher name
- **Reporter field**: Text input for reporter name
- **Location field**: Text input for location

All fields are optional and use Bootstrap form styling.

### 4. Dashboard - Edit Post View
**File**: `resources/views/dashboard/post/edit.blade.php`

Added the same three fields with pre-populated values from existing posts:
```blade
<input type="text" class="form-control" name="publisher" value="{{ $post->publisher ?? '' }}" />
<input type="text" class="form-control" name="reporter" value="{{ $post->reporter ?? '' }}" />
<input type="text" class="form-control" name="location" value="{{ $post->location ?? '' }}" />
```

### 5. Dashboard PostController Update
**File**: `app/Http/Controllers/Dashboard/PostController.php`

#### In `store()` method:
- Added validation rules for the three fields:
```php
"publisher" => ["nullable", "string"],
"reporter" => ["nullable", "string"],
"location" => ["nullable", "string"],
```
- Added field assignments when creating post:
```php
"publisher" => $validated["publisher"] ?? null,
"reporter" => $validated["reporter"] ?? null,
"location" => $validated["location"] ?? null,
```

#### In `update()` method:
- Added same validation rules
- Added field updates:
```php
$post->publisher = $validated["publisher"] ?? null;
$post->reporter = $validated["reporter"] ?? null;
$post->location = $validated["location"] ?? null;
```

### 6. Frontend Post View
**File**: `resources/views/frontend/post/index.blade.php`

Added a new section to display these fields on the published post page:
```blade
@if ($post->publisher || $post->reporter || $post->location)
<div class="post-meta-info mb-4">
    @if ($post->publisher)
    <p><strong>Publisher:</strong> {{ $post->publisher }}</p>
    @endif
    @if ($post->reporter)
    <p><strong>Reporter:</strong> {{ $post->reporter }}</p>
    @endif
    @if ($post->location)
    <p><strong>Location:</strong> {{ $post->location }}</p>
    @endif
</div>
@endif
```

The section only displays if at least one of the three fields has a value.

## Usage

### Creating a Post
1. Go to Dashboard → Posts → New Post
2. Fill in all regular post information
3. Scroll down to find the new fields:
   - **Publisher**: Enter the publisher name (optional)
   - **Reporter**: Enter the reporter name (optional)
   - **Location**: Enter the location (optional)
4. Publish the post

### Editing a Post
1. Go to Dashboard → Posts → Edit
2. Edit the Publisher, Reporter, and/or Location fields
3. Click Update

### Viewing on Frontend
- When viewing a published post, the Publisher, Reporter, and Location will display at the top of the post content section
- Only fields with values will be displayed
- Empty fields are hidden

## Field Specifications

| Field | Type | Nullable | Max Length | Display |
|-------|------|----------|-----------|---------|
| publisher | string | Yes | 255 | Frontend |
| reporter | string | Yes | 255 | Frontend |
| location | string | Yes | 255 | Frontend |

## Database Schema

```sql
ALTER TABLE posts ADD COLUMN publisher VARCHAR(255) NULL;
ALTER TABLE posts ADD COLUMN reporter VARCHAR(255) NULL;
ALTER TABLE posts ADD COLUMN location VARCHAR(255) NULL;
```

## API/Model Usage

```php
// Get post with all information
$post = Post::find(1);

// Access the fields
echo $post->publisher;  // "CNN", "BBC", etc.
echo $post->reporter;   // "John Doe", etc.
echo $post->location;   // "New York", "London", etc.

// Create with fields
$post = Post::create([
    'title' => 'Breaking News',
    'publisher' => 'CNN',
    'reporter' => 'Jane Smith',
    'location' => 'Washington DC',
    // ...other fields...
]);

// Update fields
$post->update([
    'publisher' => 'BBC',
    'reporter' => 'John Doe',
    'location' => 'London',
]);
```

## Next Steps

1. Run the migration to apply database changes
2. Test adding/editing posts with the new fields
3. Verify fields display correctly on frontend

## Notes

- All three fields are completely optional
- Fields accept any string value
- No validation is applied beyond type checking
- Fields are preserved when posts are restored from trash
- Fields are deleted when posts are permanently deleted
