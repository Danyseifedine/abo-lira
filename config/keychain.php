<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Guards Configuration
    |--------------------------------------------------------------------------
    |
    | Configure multiple authentication guards that KeyChain should handle.
    | Each guard represents a different type of user/entity in your application.
    |
    | The package will automatically:
    | - Register Laravel authentication guards for each enabled guard
    | - Create routes like /auth/{guard}/{provider}/redirect
    | - Generate dynamic methods like create{Guard}User() and update{Guard}User()
    | - Handle polymorphic relationships with social tokens
    |
    | Example: If you add a 'merchant' guard, the package will automatically
    | look for createMerchantUser() and updateMerchantUser() methods.
    |
    */
    'guards' => [
        // Set to false to disable multi-guard functionality (use only default guard)
        'enabled' => false,

        // Default guard when none is specified in the URL
        'default_guard' => 'web',

        // Available guards configuration
        'available_guards' => [
            // Standard web guard for regular users
            'web' => [
                'enabled' => true,                          // Enable/disable this guard
                'model' => App\Models\User::class,          // Eloquent model for this guard
                'table' => 'users',                         // Database table name
                'name' => 'User',                           // Display name (used in UI)
                'redirect_after_auth' => '/admin',      // Where to redirect after login
                'middleware' => ['web'],                     // Middleware for this guard's routes
            ],

            // Restaurant guard for business owners
            // 'restaurant' => [
            //     'enabled' => true,                          // Enable/disable this guard
            //     'model' => App\Models\Restaurant::class,    // Restaurant model
            //     'table' => 'restaurants',                   // Database table name
            //     'name' => 'Restaurant',                     // Display name
            //     'redirect_after_auth' => '/restaurant-dashboard', // Restaurant dashboard
            //     'middleware' => ['web'],                     // Middleware stack
            // ],

            // Example: Admin guard (uncomment to enable)
            // 'admin' => [
            //     'enabled' => true,
            //     'model' => App\Models\Admin::class,
            //     'table' => 'admins',
            //     'name' => 'Administrator',
            //     'redirect_after_auth' => '/admin/dashboard',
            //     'middleware' => ['web', 'admin'],
            // ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Provider Services Configuration
    |--------------------------------------------------------------------------
    |
    | OAuth credentials for social authentication providers.
    | KeyChain will automatically register these in Laravel's services config.
    |
    | Required environment variables for each provider:
    | KEYCHAIN_GITHUB_CLIENT_ID, KEYCHAIN_GITHUB_CLIENT_SECRET
    | KEYCHAIN_GOOGLE_CLIENT_ID, KEYCHAIN_GOOGLE_CLIENT_SECRET
    | etc.
    |
    | The redirect URLs are automatically generated but can be overridden
    | using environment variables like KEYCHAIN_GITHUB_REDIRECT_URL
    |
    */
    'services' => [
        'github' => [
            'client_id' => env('KEYCHAIN_GITHUB_CLIENT_ID'),
            'client_secret' => env('KEYCHAIN_GITHUB_CLIENT_SECRET'),
            'redirect' => env('KEYCHAIN_GITHUB_REDIRECT_URL', env('APP_URL', 'http://localhost:8000') . '/auth/github/callback'),
        ],

        'google' => [
            'client_id' => env('KEYCHAIN_GOOGLE_CLIENT_ID'),
            'client_secret' => env('KEYCHAIN_GOOGLE_CLIENT_SECRET'),
            'redirect' => env('KEYCHAIN_GOOGLE_REDIRECT_URL', env('APP_URL', 'http://localhost:8000') . '/auth/google/callback'),
        ],

        'facebook' => [
            'client_id' => env('KEYCHAIN_FACEBOOK_CLIENT_ID'),
            'client_secret' => env('KEYCHAIN_FACEBOOK_CLIENT_SECRET'),
            'redirect' => env('KEYCHAIN_FACEBOOK_REDIRECT_URL', env('APP_URL', 'http://localhost:8000') . '/auth/facebook/callback'),
        ],

        'twitter' => [
            'client_id' => env('KEYCHAIN_TWITTER_CLIENT_ID'),
            'client_secret' => env('KEYCHAIN_TWITTER_CLIENT_SECRET'),
            'redirect' => env('KEYCHAIN_TWITTER_REDIRECT_URL', env('APP_URL', 'http://localhost:8000') . '/auth/twitter/callback'),
        ],

        'linkedin' => [
            'client_id' => env('KEYCHAIN_LINKEDIN_CLIENT_ID'),
            'client_secret' => env('KEYCHAIN_LINKEDIN_CLIENT_SECRET'),
            'redirect' => env('KEYCHAIN_LINKEDIN_REDIRECT_URL', env('APP_URL', 'http://localhost:8000') . '/auth/linkedin/callback'),
        ],

        'bitbucket' => [
            'client_id' => env('KEYCHAIN_BITBUCKET_CLIENT_ID'),
            'client_secret' => env('KEYCHAIN_BITBUCKET_CLIENT_SECRET'),
            'redirect' => env('KEYCHAIN_BITBUCKET_REDIRECT_URL', env('APP_URL', 'http://localhost:8000') . '/auth/bitbucket/callback'),
        ],

        'gitlab' => [
            'client_id' => env('KEYCHAIN_GITLAB_CLIENT_ID'),
            'client_secret' => env('KEYCHAIN_GITLAB_CLIENT_SECRET'),
            'redirect' => env('KEYCHAIN_GITLAB_REDIRECT_URL', env('APP_URL', 'http://localhost:8000') . '/auth/gitlab/callback'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enabled Social Providers
    |--------------------------------------------------------------------------
    |
    | Control which social providers are available for authentication.
    | Set to 'true' to enable, 'false' to disable.
    |
    | Only providers with proper credentials (client_id and client_secret)
    | will actually be available, even if enabled here.
    |
    | Note: Disabling a provider here will remove its routes and buttons
    | from the UI, but won't affect existing social tokens in the database.
    |
    */
    'providers' => [
        'github' => false,      // GitHub OAuth (most reliable)
        'google' => true,      // Google OAuth (requires Google Cloud setup)
        'facebook' => false,    // Facebook OAuth (requires Facebook App)
        'twitter' => false,     // Twitter OAuth (requires Twitter App)
        'linkedin' => false,    // LinkedIn OAuth (requires LinkedIn App)
        'bitbucket' => false,  // Bitbucket OAuth (disabled by default)
        'gitlab' => false,     // GitLab OAuth (disabled by default)
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the automatically registered authentication routes.
    |
    | Generated routes pattern:
    | - Single guard: GET /auth/{provider}/redirect, GET /auth/{provider}/callback
    | - Multi guard: GET /auth/{guard}/{provider}/redirect, GET /auth/{guard}/{provider}/callback
    |
    */
    'routes' => [
        'enabled' => true,                  // Enable automatic route registration
        'prefix' => 'auth',                 // URL prefix for all social auth routes
        'middleware' => ['web'],            // Default middleware applied to all routes
        'guard_parameter' => 'guard',       // Route parameter name for guard detection
    ],

    /*
    |--------------------------------------------------------------------------
    | User Management Configuration
    |--------------------------------------------------------------------------
    |
    | Default settings for user creation and management during social authentication.
    | These can be overridden per guard or in your custom methods.
    |
    | - auto_create: Automatically create new users when they don't exist
    | - auto_link: Link social accounts to existing users with same email
    | - update_on_login: Update user data from social provider on each login
    | - fillable_fields: Map social provider fields to user model attributes
    |
    */
    'user' => [
        'auto_create' => true,              // Create users automatically if they don't exist
        'auto_link' => true,                // Link social accounts to existing users by email
        'update_on_login' => true,          // Update user info from social provider on login

        // Field mapping from social provider to user model
        'fillable_fields' => [
            'name' => 'name',               // Provider 'name' → model 'name' field
            'email' => 'email',             // Provider 'email' → model 'email' field
            'avatar' => 'avatar_url',       // Provider 'avatar' → model 'avatar_url' field
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Management Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for storing and managing social authentication tokens.
    | Tokens are stored in the key_chain_tokens table with polymorphic
    | relationships to your user models.
    |
    */
    'tokens' => [
        'store_tokens' => true,             // Store access tokens in database
        'cleanup_expired' => true,          // Automatically cleanup expired tokens
        'cleanup_days' => 30,               // Delete expired tokens older than X days

        'expiration' => [
            'infinite' => true,            // Set to true for tokens that never expire
            'default_expiry' => 3600,       // Default token expiry in seconds (1 hour)
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect Configuration
    |--------------------------------------------------------------------------
    |
    | Default redirect URLs after authentication success or failure.
    | Guard-specific redirects can be set in the guards configuration above
    | and will override these defaults.
    |
    */
    'redirects' => [
        'success' => '/admin',          // Default success redirect
        'failure' => '/login',              // Default failure redirect
    ],

    /*
    |--------------------------------------------------------------------------
    | Advanced Configuration
    |--------------------------------------------------------------------------
    |
    | Advanced settings for power users and custom implementations.
    |
    */
    'advanced' => [
        // Enable debug mode for detailed logging (NOT for production)
        'debug_mode' => false,

        // Custom callback handling - enables complete override of auth flow
        // When true, you can override handleCustomCallback() to write
        // your own authentication logic from scratch, bypassing KeyChain's logic
        'enable_custom_callbacks' => true,

        // Dynamic method generation - automatically handles create{Guard}User methods
        // When true, missing methods like createAdminUser() are handled dynamically
        'dynamic_methods' => false,

        // Prefix for dynamically generated methods (e.g., 'create', 'update')
        'method_prefixes' => ['create', 'update'],
    ],
];
