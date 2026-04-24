=== Enix Addons – Advanced Addons for Elementor ===
Contributors:      enamulislam
Tags:              elementor, elementor addons, accordion, faq, toggle, elementor widget, image accordion
Requires at least: 5.8
Tested up to:      6.5
Requires PHP:      7.4
Stable tag:        1.0.0
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

A premium collection of advanced widgets for Elementor – starting with the Interactive Advanced Accordion.

== Description ==

**Enix Addons** extends Elementor with lightweight, beautifully designed widgets that are built to WordPress.org coding standards.

= ✨ Current Widgets =

**Advanced Accordion** – An interactive split-screen accordion. Click any title and the matching image fades in on the right side. Fully accessible (ARIA + keyboard), with complete style controls.

= ⚡ Key Features =

* 100% built on the native Elementor API.
* Fully accessible – ARIA roles, keyboard navigation (Enter / Space).
* Mobile responsive – image stacks above accordion on small screens.
* Modular architecture – adding new widgets never touches existing code.
* No inline `<style>` or `<script>` tags – all assets enqueued properly.
* Translation-ready with `.pot` file in `/languages`.

= 🛠 Developer friendly =

Each widget lives in its own file under `includes/widgets/`. To add a new widget, create a file there and add two lines to the main plugin file – nothing else changes.

== Installation ==

1. Upload the `enix-addons` folder to `/wp-content/plugins/`.
2. Activate through **Plugins → Installed Plugins**.
3. Ensure **Elementor** (free) is installed and active.
4. Edit any page with Elementor and search **"Enix"** in the widget panel.

== Frequently Asked Questions ==

= Does this require Elementor Pro? =

No. The free version of Elementor is sufficient.

= Can I use multiple accordions on the same page? =

Yes. Each widget instance uses a unique ID so they never interfere with each other.

= Which PHP version is required? =

PHP 7.4 or higher.

== Screenshots ==

1. The Advanced Accordion widget in Elementor's editor panel.
2. Style controls – header colours, typography, border radius.
3. Frontend – inactive state (light header).
4. Frontend – active state (accent header + image fade-in on right).
5. Mobile view – image stacked above the accordion.

== Changelog ==

= 1.0.0 – 2024-04-10 =
* Initial release.
* Added: Advanced Accordion widget with interactive image panel.

== Upgrade Notice ==

= 1.0.0 =
First public release.
