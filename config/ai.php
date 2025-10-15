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

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
        'model' => env('OPENAI_MODEL', 'gpt-4'),
        'max_tokens' => env('OPENAI_MAX_TOKENS', 2000),
        'temperature' => env('OPENAI_TEMPERATURE', 0.7),
        'timeout' => env('OPENAI_TIMEOUT', 30),
    ],

    'cache' => [
        'enabled' => env('AI_CACHE_ENABLED', true),
        'ttl' => env('AI_CACHE_TTL', 3600), // 1 hour
        'prefix' => 'ai_recommendations',
    ],

    'rate_limiting' => [
        'enabled' => env('AI_RATE_LIMITING_ENABLED', true),
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
