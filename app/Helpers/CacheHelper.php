<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    public const UNIT_LINKS_KEY    = 'unit_links_links';
    public const VISITOR_LINKS_KEY = 'visitor_links_active';
    public const NEWS_ALERT_KEY    = 'news_alert_unit_';
    public const USER_LINKS_KEY    = 'user_links_';

    public static function unitLinksKey(): string
    {
        return self::UNIT_LINKS_KEY;
    }

    public static function visitorLinksKey(): string
    {
        return self::VISITOR_LINKS_KEY;
    }

    public static function newsAlertKey(int $unitId): string
    {
        return self::NEWS_ALERT_KEY . $unitId;
    }

    public static function userLinksKey(int $userId): string
    {
        return self::USER_LINKS_KEY . $userId;
    }

    public static function clearUnitLinks(): bool
    {
        return Cache::forget(self::UNIT_LINKS_KEY);
    }

    public static function clearVisitorLinks(): bool
    {
        return Cache::forget(self::VISITOR_LINKS_KEY);
    }

    public static function clearNewsAlert(int $unitId): bool
    {
        return Cache::forget(self::newsAlertKey($unitId));
    }

    public static function clearUserLinks(int $userId): bool
    {
        return Cache::forget(self::userLinksKey($userId));
    }

    public static function clearAll(): void
    {
        Cache::flush();
    }
}
