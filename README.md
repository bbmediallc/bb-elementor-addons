# B&B Media Elementor Add-Ons

Custom Elementor widgets by B&B Media: Hover Reveal List, Testimonial Slider,
Section Intro, Gallery Slider, Logo Carousel, Photo Carousel, Team Grid,
Product & Service Grid, Stats Grid and Gravity Form. Also adds a featured image column to
the Pages list and a background option to Elementor's Spacer.

## Folder layout

```
plugin/                      Everything that ships. Becomes bb-elementor-addons/ in the zip.
  bb-elementor-addons.php      Main file: version number and loader. Never rename.
  widgets/                     One file per Elementor widget.
  includes/                    Editor tweaks, Pages column, and the GitHub updater.
  assets/                      Widget CSS and JavaScript, and the update icon.
scripts/build.sh             Builds dist/bb-elementor-addons.zip.
.github/workflows/           Checks the code and publishes releases on GitHub.
CHANGELOG.md                 What changed in each version (becomes the release notes).
```

## Releasing a change

1. Make the change in `plugin/`.
2. Pick the new version number (2.12.0 → 2.12.1 for fixes, 2.13.0 for
   features) and set it in both places in `plugin/bb-elementor-addons.php`:
   the `Version:` header and `BBEA_VERSION`.
3. Add a `## [2.12.1]` section to `CHANGELOG.md`.
4. Commit, then tag and push:
   ```
   git tag v2.12.1
   git push origin main v2.12.1
   ```
5. GitHub checks the code, builds `bb-elementor-addons.zip` and publishes the
   release. This works while the repository is private.
6. Sites can only see the release while the repository is public. Use
   Dashboard > Updates > **Check again** to have a site look right away.
   WordPress downloads the zip when it installs the update, so a site that
   hasn't finished updating before the repository is private again will fail
   to update.

Sites running 2.11.0 or older have no updater. Upload 2.12.0 to each of them
once (Plugins > Add New > Upload Plugin > Replace current with uploaded);
after that they update themselves.

### Testing a change on one site first

Add this line to the test site's `wp-config.php`:

```php
define( 'BBEA_UPDATE_CHANNEL', 'beta' );
```

Release a test version, e.g. version `2.12.1-beta.1`, tagged `v2.12.1-beta.1`.
Any tag with a dash becomes a GitHub pre-release, and only sites with the line
above are offered it.

To build the zip yourself: `bash scripts/build.sh` (output in `dist/`).

## Things that must not change

- The zip folder name `bb-elementor-addons` and main file name
  `bb-elementor-addons.php`. WordPress tracks the plugin by
  `bb-elementor-addons/bb-elementor-addons.php`.
- Widget names (`get_name()`, e.g. `bb-gravity-form`). Elementor saves pages
  by widget name; renaming one breaks every page that uses it.
- The GitHub repository name `bbmediallc/bb-elementor-addons`, and a
  `bb-elementor-addons.zip` file on each release.
- `Requires PHP: 7.0`. GitHub checks every change against PHP 7.0, 7.4 and 8.3.
