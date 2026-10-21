# Changelog

Each `## [version]` section becomes the release notes on GitHub.

## [2.13.2] - 2026-10-21

### Changed
- Stats Grid looks finished out of the box, using the site's own font:
  4 columns (1 on phones), thin dividers between stats (vertical, or
  horizontal on phones), bold 56px numbers (44 tablet, 40 phone) and small
  uppercase labels. All are normal Elementor settings you can change.

### Fixed
- Stats Grid shrank to a single narrow column inside row containers. It now
  takes the full width unless Advanced > Width says otherwise.

## [2.13.1] - 2026-10-21

### Changed
- Stats Grid: the custom divider settings are replaced by Elementor's
  standard Border and Border Radius controls on each stat (Style > Stat).

## [2.13.0] - 2026-10-21

### Added
- New Stats Grid widget: a repeater of stats, each with an optional prefix,
  a number, an optional suffix (e.g. `+` or `%`) and a label. Columns per
  device, alignment, box background, border and padding, and separate styling for the number, prefix/suffix
  and label.

## [2.12.3] - 2026-10-21

### Added
- Section Intro: highlight chosen heading words. Enter word numbers in
  Content > Highlight Words (e.g. `2,3,4` or `2-4`) and pick Style > Heading >
  Highlight/Accent Color. Both start empty, so existing headings don't change.

## [2.12.2] - 2026-10-21

### Added
- Section Intro: Style > Eyebrow now has Border, Border Radius and Padding.
  The eyebrow text shrinks to fit its words, so the border wraps the text
  rather than the full width.

## [2.12.1] - 2026-10-20

### Added
- Product & Service Grid: Style > Content now has Border and Border Radius
  options, like Style > Card.

## [2.12.0] - 2026-10-20

### Added
- Updates from GitHub: sites are offered new versions on Dashboard > Updates
  like any other plugin, and the Plugins page shows "Enable auto-updates".
- Test channel: sites with `define( 'BBEA_UPDATE_CHANNEL', 'beta' );` in
  wp-config.php are also offered pre-release versions.
- Plugin header: Requires at least 6.5, Tested up to 7.1, Requires PHP 7.0,
  and an Update URI so WordPress.org never offers a different plugin with the
  same folder name.

## [2.11.0]

Last version before this repository.
