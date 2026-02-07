# Quick Start Guide - Post Multiple Links Feature

## Installation

After pulling the latest code, run the migration:

```bash
php artisan migrate
```

This creates the `post_links` table needed for storing post links.

## Usage

### Dashboard - Create Post with Links

1. Navigate to Dashboard → Posts → New Post
2. Fill in post title, content, category, tags, and thumbnail
3. Scroll down to the **Links** section
4. Enter the link title and URL for each link you want to add
5. Click **"Add Another Link"** button to add more links (optional)
6. Use the trash icon to remove any unwanted links
7. Click **"Publish"** button to create the post with links

### Dashboard - Edit Post Links

1. Navigate to Dashboard → Posts → All Posts
2. Click **Edit** on the post you want to modify
3. Scroll to the **Links** section
4. Edit, add, or remove links as needed:
   - Edit existing link values in the text fields
   - Click trash icon to remove a link
   - Click **"Add Another Link"** to add new links
5. Click **"Update"** button to save changes

### Frontend - View Post Links

1. Visit any published post on the frontend
2. Scroll down to the **"Related Links"** section
3. All associated links are displayed in a list
4. Click any link to open it in a new tab

## Form Validation

The system validates:
- **Link Title**: Required if adding links (must be a string)
- **Link URL**: Required if adding links (must be a valid URL format)
- Examples of valid URLs: `https://example.com`, `http://example.com/page`
- Examples of invalid URLs: `example.com` (missing protocol), `not a url`

## Database Structure

### post_links table
```
id          - Primary key
post_id     - Foreign key (references posts.id, cascading delete)
title       - Link title/display name
url         - Link URL
order       - Display order (0-based index)
created_at  - Timestamp
updated_at  - Timestamp
```

## API/Model Usage

```php
// Get a post with all its links
$post = Post::with('links')->find(1);

// Get all links for a post
$links = $post->links;
// Links are automatically ordered by 'order' field

// Access individual link properties
foreach ($post->links as $link) {
    echo $link->title;
    echo $link->url;
}

// Count links
$linkCount = $post->links->count();
```

## Features

- ✅ Multiple links per post (unlimited)
- ✅ Easy add/remove in dashboard
- ✅ Edit existing links
- ✅ URL validation
- ✅ Links display on frontend
- ✅ Responsive design
- ✅ Links deleted when post is deleted
- ✅ Links preserved when post is restored from trash

## Troubleshooting

**Q: Links are not showing on the frontend**
- A: Ensure the post status is "Published" (not Draft)
- A: Verify the post has links added in the dashboard
- A: Check if links count shows 0 in the database

**Q: Link validation errors**
- A: Ensure URLs start with `http://` or `https://`
- A: Link titles must not be empty
- A: URLs must be properly formatted

**Q: Database migration error**
- A: Run `php artisan migrate --refresh` (caution: this resets your database)
- A: Check database connection in `.env` file

## Next Steps

- Consider adding link categories/types in the future
- Add link analytics (track clicks)
- Add link icons/favicons
- Add link descriptions/notes
