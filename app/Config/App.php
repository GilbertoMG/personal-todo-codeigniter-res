<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * App Configuration
 *
 * @immutable
 */
class App extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Base Site URL
     * --------------------------------------------------------------------------
     *
     * URL to your CodeIgniter root. Typically this will be your base URL,
     * WITH a trailing slash:
     *
     *    http://example.com/
     *
     * If not set, CodeIgniter will attempt to guess the protocol, domain and
     * path to your installation. However, you should always configure this
     * explicitly and never rely on auto-guessing, especially in production.
     */
    public string $baseURL = 'http://localhost:8080/';

    /**
     * --------------------------------------------------------------------------
     * Allowed Hostnames in the Request
     * --------------------------------------------------------------------------
     *
     * If you want to allow multiple hostnames in the request, you can add them
     * to this array. Setting this will prevent requests with any hostname not
     * in this list from reaching your application.
     *
     * E.g.:
     *    public array $allowedHostnames = ['www.example.com', 'media.example.com'];
     */
    public array $allowedHostnames = [];

    /**
     * --------------------------------------------------------------------------
     * Index File
     * --------------------------------------------------------------------------
     *
     * Typically this will be your index.php file, unless you've renamed it to
     * something else. If you are using mod_rewrite to remove the page set this
     * variable so that it is blank.
     */
    public string $indexPage = '';

    /**
     * --------------------------------------------------------------------------
     * URI PROTOCOL
     * --------------------------------------------------------------------------
     *
     * This item determines which server global should be used to retrieve the
     * URI string.  The default setting of 'REQUEST_URI' works for most servers.
     * If your links do not seem to work, try one of the other delicious flavors:
     *
     * 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
     * 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
     * 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
     *
     * WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
     */
    public string $uriProtocol = 'REQUEST_URI';

    /**
     * --------------------------------------------------------------------------
     * Allowed URL Characters
     * --------------------------------------------------------------------------
     *
     * This lets you specify which characters are permitted within your URLs.
     * When someone tries to submit a URL with disallowed characters they will
     * get a warning message.
     *
     * As a security measure you are STRONGLY encouraged to restrict URLs to
     * as few characters as possible. By default only these are allowed:
     *
     * u|{alpha}|{digit}|~|.|-|_|,|;|:!|*|@|&|=|+|$|?|%|#|[|]|>|<|/|\|{|}|^|`
     *
     * @see https://www.ietf.org/rfc/rfc3986.txt
     * @see https://owasp.org/www-community/attacks/Path_Traversal
     */
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    /**
     * --------------------------------------------------------------------------
     * Default Locale
     * --------------------------------------------------------------------------
     *
     * The Locale roughly represents the language and location that your visitor
     * is viewing the site from. It affects the language strings and other
     * strings (like currency markers, numbers, etc), that your program
     * should run under for this request.
     */
    public string $defaultLocale = 'en';

    /**
     * --------------------------------------------------------------------------
     * Negotiate Locale
     * --------------------------------------------------------------------------
     *
     * If true, the current Request object will automatically determine the
     * language to use based on the value of the Accept-Language header.
     *
     * If false, no automatic detection will be performed.
     */
    public bool $negotiateLocale = false;

    /**
     * --------------------------------------------------------------------------
     * Supported Locales
     * --------------------------------------------------------------------------
     *
     * If $negotiateLocale is true, this array lists the locales supported
     * by the application in descending order of priority. If no match is
     * found, the first locale will be used.
     */
    public array $supportedLocales = ['en'];

    /**
     * --------------------------------------------------------------------------
     * Application Timezone
     * --------------------------------------------------------------------------
     *
     * The default timezone that will be used in your application to display
     * dates with the date helper, and can be retrieved through app_timezone()
     */
    public string $appTimezone = 'UTC';

    /**
     * --------------------------------------------------------------------------
     * Default Character Set
     * --------------------------------------------------------------------------
     *
     * This determines which character set is used by default in various methods
     * that require a character set to be provided.
     *
     * @see http://php.net/htmlspecialchars
     */
    public string $charset = 'UTF-8';

    /**
     * --------------------------------------------------------------------------
     * Force Global Secure Requests
     * --------------------------------------------------------------------------
     *
     * If true, this will force every request made to this application to be
     * made via a secure connection (HTTPS). If the incoming request is not
     * secure, the user will be redirected to a secure version of the page
     * and the HTTP Strict Transport Security header will be set.
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * --------------------------------------------------------------------------
     * Reverse Proxy IPs
     * --------------------------------------------------------------------------
     *
     * If your server is behind a reverse proxy, you must whitelist the proxy
     * IP addresses from which CodeIgniter should trust headers such as
     * X-Forwarded-For and X-Client-Ip in order to properly identify
     * the visitor's IP address.
     *
     * You need to set a proxy IP address or IP address with subnet mask and
     * HTTP header for the client IP address:
     *
     * Here are some examples:
     *    [
     *        '10.0.1.200'     => 'X-Forwarded-For',
     *        '10.0.1.201'     => 'X-Forwarded-For',
     *        '10.0.1.202/28'  => 'X-Forwarded-For',
     *        '127.0.0.1'      => 'X-Client-Ip',
     *    ]
     */
    public array $proxyIPs = [];

    /**
     * --------------------------------------------------------------------------
     * CSRF Token Name
     * --------------------------------------------------------------------------
     *
     * Token name for Cross Site Request Forgery protection cookie.
     */
    public string $CSRFTokenName = 'csrf_test_name';

    /**
     * --------------------------------------------------------------------------
     * CSRF Header Name
     * --------------------------------------------------------------------------
     *
     * Token name for Cross Site Request Forgery protection cookie.
     */
    public string $CSRFHeaderName = 'X-CSRF-TOKEN';

    /**
     * --------------------------------------------------------------------------
     * CSRF Cookie Name
     * --------------------------------------------------------------------------
     *
     * Cookie name for Cross Site Request Forgery protection cookie.
     */
    public string $CSRFCookieName = 'csrf_cookie_name';

    /**
     * --------------------------------------------------------------------------
     * CSRF Expire
     * --------------------------------------------------------------------------
     *
     * Expiration time for Cross Site Request Forgery protection cookie.
     *
     * Defaults to two hours (in seconds).
     */
    public int $CSRFExpire = 7200;

    /**
     * --------------------------------------------------------------------------
     * CSRF Regenerate
     * --------------------------------------------------------------------------
     *
     * Regenerate CSRF Token on every submission or keep it static for the life of the cookie.
     */
    public bool $CSRFRegenerate = true;

    /**
     * --------------------------------------------------------------------------
     * CSRF Redirect
     * --------------------------------------------------------------------------
     *
     * Redirect to previous page with error on failure or continue showing the submission form with the error.
     */
    public bool $CSRFRedirect = false;

    /**
     * --------------------------------------------------------------------------
     * CSRF SameSite
     * --------------------------------------------------------------------------
     *
     * Setting for CSRF SameSite cookie token. Allowed values are:
     * - None
     * - Lax
     * - Strict
     * - ''
     *
     * Defaults to `Lax` as recommended in this link:
     *
     * @see https://portswigger.net/web-security/csrf/samesite-cookies
     */
    public string $CSRFSameSite = 'Lax';

    /**
     * --------------------------------------------------------------------------
     * Content Security Policy
     * --------------------------------------------------------------------------
     *
     * Enables the Response's Content Secure Policy to restrict the sources that
     * can be used for images, scripts, CSS files, audio, video, etc. If enabled,
     * the Response object will populate default values for the policy from the
     * `ContentSecurityPolicy.php` file in your config folder.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
     */
    public bool $CSPEnabled = false;
}
