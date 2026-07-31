#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST="$ROOT/dist"
PLUGIN="nvconsult-core"
THEME="nvconsult"
rm -rf "$DIST" && mkdir -p "$DIST/$PLUGIN" "$DIST/$THEME"
cp -R "$ROOT/wp-content/plugins/$PLUGIN/." "$DIST/$PLUGIN/"
cp -R "$ROOT/wp-content/themes/$THEME/." "$DIST/$THEME/"
find "$DIST" -type f \( -name '.DS_Store' -o -name '*.log' \) -delete
(cd "$DIST" && zip -qr "nvconsult-core.zip" "$PLUGIN" && zip -qr "nvconsult-theme.zip" "$THEME")
rm -rf "$DIST/$PLUGIN" "$DIST/$THEME"
printf 'Built:\n%s\n%s\n' "$DIST/nvconsult-core.zip" "$DIST/nvconsult-theme.zip"
