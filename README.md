# Devllo Wine Essentials

A WooCommerce wine profile plugin. This repository is the development source tree and is not directly installable in WordPress without a build.

## Dev vs. Build

- The raw repo will fatal if activated in WordPress because it does not include `vendor/autoload.php`.
- Build an installable copy before activation.

### Build (installable copy)

From the repository root:

```bash
composer install --no-dev
./bin/package.sh              # optional custom name: ./bin/package.sh devllo-wine-essentials-build
```

Outputs:
- `dist/devllo-wine-essentials/` (activatable folder)
- `dist/devllo-wine-essentials.zip` (installable ZIP)

### Local testing

- Symlink or copy `dist/devllo-wine-essentials/` into `wp-content/plugins/`, then activate there.
- The raw repo in `wp-content/plugins` will fatal without a build.

### Dev tooling

- PHP autoload: PSR-4 under `src/` (see `composer.json`)
- Assets: placeholder npm build (extend `package.json`/scripts for real builds)
- CI: `.github/workflows/release.yml` builds/packages and uploads the ZIP
