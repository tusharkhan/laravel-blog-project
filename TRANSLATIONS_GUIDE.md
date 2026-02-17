# Using Translations in Views - Quick Guide

## How to Use Translations in Blade Templates

The Laravel blog project now supports both English and Bengali languages. To use translations in your Blade templates, use the `__()` helper function.

### Basic Syntax

```blade
{{ __('messages.key_name') }}
```

### Examples

**Frontend Navigation:**
```blade
<a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a>
<a href="{{ route('dashboard.home') }}">{{ __('messages.dashboard') }}</a>
```

**Post Display:**
```blade
<h1>{{ __('messages.posts') }}</h1>
<p>{{ __('messages.published') }}: {{ $post->created_at }}</p>
<span>{{ __('messages.views') }}: {{ $post->views }}</span>
```

**Forms:**
```blade
<label>{{ __('messages.title') }}</label>
<input type="text" name="title" />

<label>{{ __('messages.content') }}</label>
<textarea name="content"></textarea>

<button type="submit">{{ __('messages.save') }}</button>
```

**Comments:**
```blade
<h2>{{ __('messages.comments') }}</h2>
<p>{{ __('messages.no_comments') }}</p>
<a href="#comment-form">{{ __('messages.leave_comment') }}</a>
```

## Available Translation Keys

### Frontend & Navigation
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.dashboard` | Dashboard | ড্যাশবোর্ড |
| `messages.home` | Home | হোম |
| `messages.search` | Search | খুঁজুন |
| `messages.read_more` | Read More | আরও পড়ুন |
| `messages.share` | Share | শেয়ার করুন |

### Comments
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.comment` | Comment | মন্তব্য |
| `messages.comments` | Comments | মন্তব্যসমূহ |
| `messages.no_comments` | No comments yet | এখনও কোনো মন্তব্য নেই |
| `messages.leave_comment` | Leave a Comment | একটি মন্তব্য রেখে যান |

### Posts
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.posts` | Posts | পোস্টসমূহ |
| `messages.post` | Post | পোস্ট |
| `messages.new_post` | New Post | নতুন পোস্ট |
| `messages.edit_post` | Edit Post | পোস্ট সম্পাদনা করুন |
| `messages.title` | Title | শিরোনাম |
| `messages.content` | Content | বিষয়বস্তু |
| `messages.published` | Published | প্রকাশিত |
| `messages.draft` | Draft | খসড়া |
| `messages.views` | Views | ভিউ |
| `messages.reading_time` | Reading Time | পড়ার সময় |

### Categories & Tags
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.categories` | Categories | বিভাগসমূহ |
| `messages.category` | Category | বিভাগ |
| `messages.new_category` | New Category | নতুন বিভাগ |
| `messages.category_name` | Category Name | বিভাগের নাম |
| `messages.tags` | Tags | ট্যাগ |

### Authors & Publishing
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.author` | Author | লেখক |
| `messages.publisher` | Publisher | প্রকাশক |
| `messages.reporter` | Reporter | সাংবাদিক |
| `messages.location` | Location | অবস্থান |
| `messages.date` | Date | তারিখ |

### Buttons & Actions
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.submit` | Submit | জমা দিন |
| `messages.cancel` | Cancel | বাতিল করুন |
| `messages.delete` | Delete | মুছে ফেলুন |
| `messages.edit` | Edit | সম্পাদনা করুন |
| `messages.add` | Add | যোগ করুন |
| `messages.save` | Save | সংরক্ষণ করুন |
| `messages.update` | Update | আপডেট করুন |
| `messages.back` | Back | পিছনে |
| `messages.publish` | Publish | প্রকাশ করুন |

### Authentication
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.login` | Login | লগইন করুন |
| `messages.logout` | Logout | লগআউট করুন |
| `messages.register` | Register | নিবন্ধন করুন |
| `messages.email` | Email | ইমেইল |
| `messages.password` | Password | পাসওয়ার্ড |
| `messages.confirm_password` | Confirm Password | পাসওয়ার্ড নিশ্চিত করুন |
| `messages.remember_me` | Remember Me | আমাকে মনে রাখুন |
| `messages.forgot_password` | Forgot Password? | পাসওয়ার্ড ভুলে গেছেন? |

### Pagination
| Key | English | বাংলা |
|-----|---------|--------|
| `messages.first` | First | প্রথম |
| `messages.last` | Last | শেষ |
| `messages.previous` | Previous | আগের |
| `messages.next` | Next | পরবর্তী |

## Adding New Translations

To add new translation keys:

1. **Open the language files:**
   - English: `resources/lang/en/messages.php`
   - Bengali: `resources/lang/bn/messages.php`

2. **Add the new key-value pair** in both files:
   ```php
   'new_key' => 'English text',
   ```

3. **Use in templates:**
   ```blade
   {{ __('messages.new_key') }}
   ```

## How the Language Switching Works

1. **Default Language**: Bengali (বাংলা)
2. **Fallback Language**: English
3. **User Can Switch**: Via the language dropdown in the header
4. **Preference Storage**: Session-based (persists during the browsing session)

## Testing Translations

In your PHP artisan tinker:
```bash
php artisan tinker
```

Then:
```php
> __('messages.home')
=> "হোম"

> app()->setLocale('en');
> __('messages.home')
=> "Home"
```

