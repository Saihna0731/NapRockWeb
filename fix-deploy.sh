#!/usr/bin/env bash
set -euo pipefail

cd ~/NapRockWeb

echo "=== 1/7  Fixing bootstrap/app.php (trust proxies) ==="
cat > bootstrap/app.php << 'PHPEOF'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
                | Request::HEADER_X_FORWARDED_PREFIX,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
PHPEOF

echo "=== 2/7  Fixing AppServiceProvider (force HTTPS) ==="
cat > app/Providers/AppServiceProvider.php << 'PHPEOF'
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
PHPEOF

echo "=== 3/7  Fixing docker/nginx.conf (forward proxy headers) ==="
cat > docker/nginx.conf << 'NGINXEOF'
server {
    listen 8080;
    listen [::]:8080;

    server_name _;
    root /var/www/public;
    index index.php;

    access_log /dev/stdout;
    error_log /dev/stderr warn;

    client_max_body_size 20m;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~* \.(?:css|js|map|jpg|jpeg|gif|png|svg|ico|webp|ttf|otf|eot|woff|woff2)$ {
        expires 7d;
        access_log off;
    }

    location ~ \.php$ {
        try_files $uri =404;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        fastcgi_param HTTP_X_FORWARDED_FOR $http_x_forwarded_for;
        fastcgi_param HTTP_X_FORWARDED_HOST $http_x_forwarded_host;
        fastcgi_param HTTP_X_FORWARDED_PORT $http_x_forwarded_port;
        fastcgi_param HTTP_X_FORWARDED_PROTO $http_x_forwarded_proto;
        fastcgi_param HTTP_X_FORWARDED_PREFIX $http_x_forwarded_prefix;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_intercept_errors on;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINXEOF

echo "=== 4/7  Fixing vite.config.js (single entry) ==="
cat > vite.config.js << 'VITEEOF'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
VITEEOF

echo "=== 5/7  Fixing resources/js/app.js (CSS import) ==="
if ! grep -q "css/app.css" resources/js/app.js; then
    sed -i "1a import '../css/app.css';" resources/js/app.js
    echo "  Added CSS import"
else
    echo "  CSS import already present"
fi

echo "=== 6/7  Fixing blade templates (@vite single entry) ==="
sed -i "s/@vite(\['resources\/css\/app.css', 'resources\/js\/app.js'\])/@vite('resources\/js\/app.js')/g" resources/views/*.blade.php
echo "  All blade templates updated"

echo "=== 7/7  Cleaning home.blade.php (remove broken trailing HTML) ==="
python3 << 'PYEOF'
with open('resources/views/home.blade.php', 'r') as f:
    content = f.read()
idx = content.rfind('</footer>')
if idx != -1:
    clean = content[:idx + len('</footer>')] + '\n\n</body>\n\n</html>\n'
    if clean != content:
        with open('resources/views/home.blade.php', 'w') as f:
            f.write(clean)
        print('  Cleaned broken HTML after </footer>')
    else:
        print('  home.blade.php already clean')
else:
    print('  No </footer> found, skipping')
PYEOF

echo ""
echo "=========================================="
echo "  All fixes applied!"
echo "=========================================="
echo ""
echo "Now deploy with:"
echo '  NEW_KEY="base64:DyGaWdjisjlWzrBRh1/ga1KkQqJVO6Uw5PA1qzlGgx0="'
echo '  gcloud run deploy naprockweb-web --source . --region asia-southeast1 --allow-unauthenticated --set-env-vars APP_ENV=production,APP_DEBUG=false,LOG_CHANNEL=stderr,APP_URL=https://est-monitoring.online,SESSION_DRIVER=file,CACHE_STORE=file,QUEUE_CONNECTION=sync,APP_KEY=$NEW_KEY'
