# Post Multiple Links Feature Implementation

## Overview
Added functionality to allow each blog post to have multiple associated links. Users can add, edit, and remove links through the dashboard, and these links are displayed on the frontend post page.

## Files Created

### 1. Migration
- **File**: `database/migrations/2026_02_07_000000_create_post_links_table.php`
- **Table**: `post_links`
- **Columns**:
  - `id` (Primary Key)
  - `post_id` (Foreign Key → posts table, cascading delete)
  - `title` (string) - Link display name
  - `url` (string) - Link URL
  - `order` (integer) - Display order
  - `created_at` and `updated_at` (timestamps)

### 2. Model
- **File**: `app/Models/PostLink.php`
- **Relationship**: `belongsTo(Post::class)`
- **Fillable Fields**: `post_id`, `title`, `url`, `order`

### 3. Factory
- **File**: `database/factories/PostLinkFactory.php`
- **Purpose**: Generate fake post links for testing

## Files Modified

### 1. Post Model (`app/Models/Post.php`)
- Added `links()` relationship method
- Returns `hasMany(PostLink::class)` ordered by `order` field

### 2. Dashboard PostController (`app/Http/Controllers/Dashboard/PostController.php`)
- **Added Import**: `use App\Models\PostLink;`
- **store() method**:
  - Added validation for links: `links.*.title` and `links.*.url`
  - Creates PostLink records when post is created
- **edit() method**:
  - Loads links relationship with `with(["tags", "links"])`
- **update() method**:
  - Added validation for links
  - Deletes old links and creates new ones on update
- **delete() method**:
  - Removes links when post is permanently deleted with `$post->links()->forceDelete()`

### 3. Frontend PostController (`app/Http/Controllers/Frontend/PostController.php`)
- **index() method**:
  - Added `links` to relationship loading: `with(["category", "user", "tags", "links", ...])`
  - Added `links` to count: `withCount([..., "links", ...])`

### 4. Dashboard Add Post View (`resources/views/dashboard/post/add.blade.php`)
- **Added Links Section**:
  - Dynamic form fields for link title and URL
  - "Add Another Link" button
  - JavaScript to handle adding/removing links dynamically
  - Counter tracks link index for form submission
- **JavaScript Features**:
  - `linkCount` variable tracks number of links
  - Click handler on "Add Another Link" button
  - Remove button functionality for each link

### 5. Dashboard Edit Post View (`resources/views/dashboard/post/edit.blade.php`)
- **Added Links Section**:
  - Displays existing links with pre-filled values
  - Shows "Add Another Link" button
  - Remove buttons for each existing link
  - Default empty link form if no links exist
- **JavaScript Features**:
  - Initializes `linkCount` with existing link count
  - Same add/remove functionality as add view

### 6. Frontend Post View (`resources/views/frontend/post/index.blade.php`)
- **Added Links Display**:
  - Section titled "Related Links"
  - Uses list-group Bootstrap component
  - Links open in new tab with `target="_blank"`
  - Includes Font Awesome external link icon
  - Only shows if post has links (`@if ($post->links_count > 0)`)

## Data Validation

**In store() and update() methods:**
```php
"links" => ["nullable", "array"],
"links.*.title" => ["required_with:links", "string"],
"links.*.url" => ["required_with:links", "url"],
```

- Links are optional
- If links are provided, each must have:
  - A `title` (string)
  - A valid `url` (must be a valid URL format)

## Usage Flow

### Creating a Post with Links
1. Fill in basic post details (title, content, category, etc.)
2. Scroll to "Links" section
3. Enter link title and URL in the first row
4. Click "Add Another Link" to add more links
5. Click trash icon to remove a link
6. Submit form to create post with links

### Editing a Post with Links
1. Edit existing post
2. Existing links are pre-populated
3. Edit, add, or remove links as needed
4. Submit form to update
5. Old links are deleted and replaced with new ones

### Displaying Links on Frontend
- Post links display in "Related Links" section
- Located before tags section
- Each link opens in a new tab
- Links are ordered by their `order` field

## Database Migration

Run the following to apply changes:
```bash
php artisan migrate
```

This will create the `post_links` table with the foreign key constraint.

## Features
- ✅ Multiple links per post
- ✅ Add/remove links dynamically in dashboard
- ✅ Edit existing links
- ✅ Display links on frontend
- ✅ Cascading delete (links removed when post is deleted)
- ✅ Link ordering support
- ✅ URL validation
- ✅ Responsive form design
