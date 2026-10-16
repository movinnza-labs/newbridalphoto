<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base Site URL — set this in your .env file:
     *   app.baseURL = 'https://thebridal.photography/'
     */
    // public string $baseURL = 'https://shailendrakadulkar.com/demo/thebridalphotography/';
    public string $baseURL = 'http://localhost:8080/thebridal/';

    /**
     * Allowed hostnames other than the one in $baseURL.
     * @var list<string>
     */
    public array $allowedHostnames = [];

    /**
     * Index File — set to '' for clean URLs (mod_rewrite handles it)
     */
    public string $indexPage = '';

    public string $uriProtocol = 'REQUEST_URI';

    /**
     * Permitted URI characters
     */
    public string $permittedURIChars = 'a-z 0-9~%.:_\-@';

    public string $defaultLocale    = 'en';
    public bool   $negotiateLocale  = false;

    /** @var list<string> */
    public array $supportedLocales = ['en'];

    public string $appTimezone = 'Asia/Kolkata';
    public string $charset     = 'UTF-8';
    public bool   $forceGlobalSecureRequests = false;
    public bool   $CSPEnabled  = false;

    // Proxy
    public array $proxyIPs = [];
}
