#!/usr/bin/env bash
# Builds dist/bb-elementor-addons.zip from plugin/.
#
#   scripts/build.sh            build
#   scripts/build.sh v2.12.0    build, and fail unless the version is 2.12.0
#
# The zip's top folder must be "bb-elementor-addons": that is the folder installed
# on every site, and a different name would install a second copy instead
# of updating.
set -euo pipefail

cd "$(dirname "$0")/.."

header_version=$(sed -n 's/^ \* Version:[[:space:]]*//p' plugin/bb-elementor-addons.php | tr -d '\r')
constant_version=$(sed -n "s/^define( 'BBEA_VERSION', '\([^']*\)' );/\1/p" plugin/bb-elementor-addons.php)

if [ -z "$header_version" ] || [ "$header_version" != "$constant_version" ]; then
    echo "Version mismatch. Make both the same:" >&2
    echo "  Version: header in bb-elementor-addons.php  $header_version" >&2
    echo "  BBEA_VERSION in bb-elementor-addons.php     $constant_version" >&2
    exit 1
fi

if [ $# -gt 0 ] && [ "${1#v}" != "$header_version" ]; then
    echo "Tag $1 does not match plugin version $header_version." >&2
    exit 1
fi

rm -rf dist
mkdir -p dist/build
cp -R plugin dist/build/bb-elementor-addons
find dist/build -name '.DS_Store' -delete

(cd dist/build && zip -qrX ../bb-elementor-addons.zip bb-elementor-addons)
rm -rf dist/build

echo "Built dist/bb-elementor-addons.zip (version $header_version)"
