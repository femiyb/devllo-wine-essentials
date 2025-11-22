#!/usr/bin/env bash
set -euo pipefail

# Build and package Devllo Wine Essentials into dist/devllo-wine-essentials and a ZIP.
# Run from the plugin root: ./bin/package.sh

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
DIST_ROOT="$ROOT/dist"
BUILD_NAME="${1:-devllo-wine-essentials}"
BUILD_DIR="$DIST_ROOT/$BUILD_NAME"

echo ">>> Cleaning dist..."
rm -rf "$BUILD_DIR" "$DIST_ROOT/${BUILD_NAME}.zip"
mkdir -p "$BUILD_DIR"

if command -v npm >/dev/null 2>&1 && [ -f "$ROOT/package.json" ]; then
  echo ">>> Installing npm deps (if needed)..."
  npm ci --ignore-scripts || npm install --ignore-scripts
  echo ">>> Running npm build (if defined)..."
  npm run build || true
fi

if command -v composer >/dev/null 2>&1 && [ -f "$ROOT/composer.json" ]; then
  echo ">>> Installing composer deps (no-dev)..."
  composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
fi

echo ">>> Syncing plugin files to dist..."
rsync -av \
  --exclude '.git*' \
  --exclude 'node_modules' \
  --exclude 'dist' \
  --exclude '.github' \
  --exclude '.DS_Store' \
  --exclude 'tests' \
  --exclude 'resources' \
  --exclude 'bin' \
  --exclude '.distignore' \
  --exclude 'phpcs.xml' \
  --exclude 'phpunit.xml' \
  --exclude 'psalm.xml' \
  "$ROOT"/ "$BUILD_DIR"/

echo ">>> Creating ZIP..."
cd "$DIST_ROOT"
zip -r "${BUILD_NAME}.zip" "${BUILD_NAME}" >/dev/null
echo "Done. Output: $DIST_ROOT/${BUILD_NAME}.zip"
