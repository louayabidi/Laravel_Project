<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for AI services integration, including OpenAI API settings,
    | caching, rate limiting, and data anonymization settings.
    |
    */

    'google' => [
        'api_key' => env('GOOGLE_AI_API_KEY'),
        'base_url' => env('GOOGLE_AI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
        'model' => env('GOOGLE_AI_MODEL', 'gemini-pro'),
        'max_tokens' => env('GOOGLE_AI_MAX_TOKENS', 2000),
        'temperature' => env('GOOGLE_AI_TEMPERATURE', 0.7),
        'timeout' => env('GOOGLE_AI_TIMEOUT', 30),
    ],

    'cache' => [
        'enabled' => env('AI_CACHE_ENABLED', false),
        'ttl' => env('AI_CACHE_TTL', 3600), // 1 hour
        'prefix' => 'ai_recommendations',
    ],

    'rate_limiting' => [
        'enabled' => env('AI_RATE_LIMITING_ENABLED', false),
        'max_requests_per_minute' => env('AI_RATE_LIMIT_MAX_REQUESTS', 10),
        'max_requests_per_hour' => env('AI_RATE_LIMIT_MAX_HOURLY', 50),
    ],

    'anonymization' => [
        'enabled' => env('AI_ANONYMIZATION_ENABLED', true),
        'remove_personal_data' => env('AI_REMOVE_PERSONAL_DATA', true),
        'hash_identifiers' => env('AI_HASH_IDENTIFIERS', true),
    ],

    'fallback' => [
        'enabled' => env('AI_FALLBACK_ENABLED', true),
        'use_rule_based' => env('AI_FALLBACK_RULE_BASED', true),
    ],

    'logging' => [
        'enabled' => env('AI_LOGGING_ENABLED', true),
        'level' => env('AI_LOG_LEVEL', 'info'),
        'anonymize_logs' => env('AI_ANONYMIZE_LOGS', true),
    ],

    'features' => [
        'health_recommendations' => env('AI_HEALTH_RECOMMENDATIONS', true),
        'risk_assessment' => env('AI_RISK_ASSESSMENT', true),
        'trend_analysis' => env('AI_TREND_ANALYSIS', true),
        'personalized_advice' => env('AI_PERSONALIZED_ADVICE', true),
    ],
];
