=== UploadShield ===
Contributors: akaeid-hasan
Tags: image upload limit, media library, image size, wordpress images, upload restriction
Requires at least: 6.0
Tested up to: 7.1.2
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Control maximum WordPress image upload sizes for administrators and other users.

== Description ==

UploadShield is a lightweight WordPress image upload size limiter created by Akaeid Hasan.

It blocks oversized images before WordPress moves them into the Media Library and lets site administrators configure separate limits for administrators and other users.

Features:

* Separate image upload limits for administrators and other users.
* Set limits in KB or MB.
* Disable either limit when unrestricted uploads are needed.
* Clear upload error showing the allowed size and actual image size.
* Works with WordPress' standard upload pipeline, including Media Library and common upload flows that use it.
* Clean responsive settings interface.
* Small, dismissible administrator support reminder on a fixed 15-day cycle.
* Closing the reminder hides it for 15 days for that administrator.
* No frontend badge, ad, tracking script, or public-facing branding.

Created and maintained by Akaeid Hasan, WordPress Developer, Elementor and WooCommerce specialist.
Website: https://akaeidhasan.com/

== Installation ==

1. Upload the `upload-shield` folder to `/wp-content/plugins/` or install the ZIP from Plugins > Add New > Upload Plugin.
2. Activate UploadShield.
3. Go to Settings > UploadShield.
4. Configure the administrator and other-user image limits.
5. Save settings.

== Frequently Asked Questions ==

= Does UploadShield change WordPress' server upload limit? =

No. UploadShield adds an image-specific maximum inside WordPress. PHP/server limits still apply independently.

= Does it block videos, PDFs or ZIP files? =

No. Version 1.0.0 targets image uploads only.

= Does it show branding on my public website? =

No. UploadShield does not add frontend branding.

== Changelog ==

= 1.0.1 =
* Removed dashboard reminder controls from plugin settings.
* Support reminder now uses a fixed 15-day cycle.
* Closing the reminder hides it for 15 days for that administrator.

= 1.0.0 =
* Initial release.
* Separate administrator and other-user image limits.
* KB/MB controls.
* Dashboard-only dismissible support reminder.
* Branded responsive settings interface.
