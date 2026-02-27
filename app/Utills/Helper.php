<?php

namespace App\Utills;

class Helper
{
    /**
     * Convert Bangla numbers to English numbers
     *
     * @param  string  $number  String containing Bangla digits
     * @return string String with English digits
     *
     * Examples:
     *   banglaToEnglishNumberConverter('२२/०६/१९८०') => '22/06/1980'
     *   banglaToEnglishNumberConverter('०५') => '05'
     */
    public static function banglaToEnglishNumberConverter($number)
    {
        return str_replace(['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'], ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], $number);
    }

    /**
     * Convert English date/datetime to Bangla format
     *
     * @param  string|null  $date  Date/datetime string
     * @param  string  $format  Output format (d M Y, d M Y h:i A, d-m-Y, etc.)
     * @param  string  $lang
     * @return string|null Bangla formatted date
     *
     * Examples:
     *   englishToBanglaDateConverter('2024-12-05') => '০৫ ডিসেম্বর ২০২৪'
     *   englishToBanglaDateConverter('2024-12-05 14:30:00', 'd M Y h:i A') => '০৫ ডিসেম্বর ২০২৪ ০২:৩০ PM'
     *   englishToBanglaDateConverter('2024-12-05', 'd-m-Y') => '০৫-১২-২০২৪'
     */
    public static function englishToBanglaDateConverter(?string $date, string $format = 'd M Y', $lang = 'bd'): ?string
    {
        if ($lang !== 'bd') {
            return $date;
        }

        if (empty($date)) {
            return '';
        }

        $months_en = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ];
        $months_bn = [
            'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
            'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর',
        ];

        $months_en_short = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
        ];
        $months_bn_short = [
            'জানু', 'ফেব্রু', 'মার্চ', 'এপ্রি', 'মে', 'জুন',
            'জুলা', 'আগস্ট', 'সেপ্টে', 'অক্টো', 'নভে', 'ডিসে',
        ];

        $days_en = [
            'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
        ];
        $days_bn = [
            'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার',
        ];

        $days_en_short = [
            'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri',
        ];
        $days_bn_short = [
            'শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহ', 'শুক্র',
        ];

        $time_en = ['AM', 'PM'];
        $time_bn = ['এএম', 'পিএম'];

        try {
            $time = strtotime($date);
            if ($time === false) {
                return $date; // Return original if parsing fails
            }

            // Format the date according to the given format
            $formatted = date($format, $time);

            // Replace month names (full)
            $formatted = str_replace($months_en, $months_bn, $formatted);

            // Replace month names (short)
            $formatted = str_replace($months_en_short, $months_bn_short, $formatted);

            // Replace day names (full)
            $formatted = str_replace($days_en, $days_bn, $formatted);

            // Replace day names (short)
            $formatted = str_replace($days_en_short, $days_bn_short, $formatted);
            // Replace AM/PM
            $formatted = str_replace($time_en, $time_bn, $formatted);

            // Convert all English numbers to Bangla
            $formatted = self::englishToBanglaNumberConverter($formatted);

            return $formatted;
        } catch (\Exception $e) {
            return $date; // Return original if any error occurs
        }
    }

    public static function englishToBanglaNumberConverter($number)
    {
        return str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'], $number);
    }

    /**
     * Generate social share URLs
     *
     * @param  string  $platform  Social media platform (facebook, twitter, linkedin, pinterest, whatsapp, telegram)
     * @param  string  $url  URL to share
     * @param  string|null  $title  Title for the share (used by some platforms)
     * @return string Share URL for the platform
     */
    public static function generateSocialShareUrl(string $platform, string $url, ?string $title = null): string
    {
        $encodedUrl = urlencode($url);
        $encodedTitle = urlencode($title ?? '');

        return match(strtolower($platform)) {
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
            'twitter' => "https://twitter.com/intent/tweet?url={$encodedUrl}&text={$encodedTitle}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}",
            'pinterest' => "https://pinterest.com/pin/create/button/?url={$encodedUrl}&description={$encodedTitle}",
            'whatsapp' => "https://wa.me/?text={$encodedTitle}%20{$encodedUrl}",
            'telegram' => "https://t.me/share/url?url={$encodedUrl}&text={$encodedTitle}",
            'email' => "mailto:?subject={$encodedTitle}&body={$encodedUrl}",
            default => $url,
        };
    }
}
