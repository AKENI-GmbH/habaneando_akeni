<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Local development (Docker)

1. Copy env for Docker: `cp .env.docker.example .env` (defaults: Postgres user/db `habaneando`, password `secret`).
2. Build and start stack (PHP-FPM + nginx + Postgres + Vite): `docker compose -f docker-compose.dev.yml up -d --build`.
3. Install PHP deps: `docker compose -f docker-compose.dev.yml exec app composer install`.
4. Generate app key: `docker compose -f docker-compose.dev.yml exec app php artisan key:generate`.
5. Run migrations: `docker compose -f docker-compose.dev.yml exec app php artisan migrate`.
6. Build frontend assets (wait ~30 s for `npm install` to finish first): `docker compose -f docker-compose.dev.yml exec vite npm run build`.
7. Web app is served at http://localhost:8080; Vite dev server (HMR) runs on http://localhost:5173.

Stop services: `docker compose -f docker-compose.dev.yml down` (add `-v` to also drop Postgres data and reinstall deps on next start).

## Auto rebuild on origin/testing updates

This repository includes a one-cycle watcher script that:

1. fetches `origin/testing`
2. checks if the upstream commit SHA changed
3. runs `docker compose -f docker-compose.dev.yml up -d --build app web` only when changed

Runtime files are written to `.branch-watch/` (ignored by git).

### Run once manually

```sh
./scripts/watch-testing-branch.sh
```

On first run, the script initializes the tracked SHA and does not restart containers.

### macOS scheduler (launchd)

1. Replace `__REPO_ROOT__` in the template and install it:

```sh
mkdir -p "$HOME/Library/LaunchAgents"
sed "s|__REPO_ROOT__|$(pwd)|g" ops/launchd/com.habaneando.testing-watch.plist > "$HOME/Library/LaunchAgents/com.habaneando.testing-watch.plist"
```

2. Load and start:

```sh
launchctl unload "$HOME/Library/LaunchAgents/com.habaneando.testing-watch.plist" 2>/dev/null || true
launchctl load "$HOME/Library/LaunchAgents/com.habaneando.testing-watch.plist"
launchctl start com.habaneando.testing-watch
```

3. Check status/logs:

```sh
launchctl list | grep com.habaneando.testing-watch
tail -f .branch-watch/watcher.log
```

4. Stop:

```sh
launchctl unload "$HOME/Library/LaunchAgents/com.habaneando.testing-watch.plist"
```

### Linux scheduler (systemd user timer)

1. Install unit files for your user session:

```sh
mkdir -p "$HOME/.config/systemd/user"
sed "s|__REPO_ROOT__|$(pwd)|g" ops/systemd/habaneando-testing-watch.service > "$HOME/.config/systemd/user/habaneando-testing-watch.service"
cp ops/systemd/habaneando-testing-watch.timer "$HOME/.config/systemd/user/habaneando-testing-watch.timer"
systemctl --user daemon-reload
```

2. Enable and start timer:

```sh
systemctl --user enable --now habaneando-testing-watch.timer
```

3. Check status/logs:

```sh
systemctl --user status habaneando-testing-watch.timer
journalctl --user -u habaneando-testing-watch.service -f
tail -f .branch-watch/watcher.log
```

4. Stop:

```sh
systemctl --user disable --now habaneando-testing-watch.timer
```

If your Linux host does not have user systemd timers, use cron:

```cron
*/5 * * * * cd /absolute/path/to/repo && ./scripts/watch-testing-branch.sh
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
