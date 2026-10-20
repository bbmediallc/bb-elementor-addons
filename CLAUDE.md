# B&B Media Elementor Add-Ons: notes for Claude

Read README.md first. It is the source of truth for layout and releases.

- Installed on live client sites. Treat every change as a production release.
- Never rename `plugin/bb-elementor-addons.php`, the `bb-elementor-addons` zip folder, or any widget's `get_name()`.
- PHP must run on 7.0: no arrow functions, `match`, typed properties, or union types. CI lints on 7.0, 7.4 and 8.3.
- Prefix functions, options and transients with `bbea_`, classes with `BBEA_`.
- Escape everything a widget prints (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`, `Utils::validate_html_tag` for tag names, Elementor's render attributes for links). JS must insert user text with `textContent`, never `innerHTML`.
- A release means bumping both version spots in the main file, adding a CHANGELOG section, then tagging `vX.Y.Z`. `scripts/build.sh` enforces that the versions match.
- Releases reach sites only while the GitHub repo is public; Austin manages its visibility by hand. Never change it yourself, and don't remind him to.
- Sister project: BB Media Core (github.com/bbmediallc/bbmediacore). Its updater is the model for this one.
