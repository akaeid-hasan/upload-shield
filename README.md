# UploadShield — WordPress Image Upload Size Limit Plugin

**UploadShield** is a lightweight WordPress image upload size limit plugin that blocks oversized images before they enter the WordPress Media Library. It lets administrators set separate maximum image upload limits for administrators and other WordPress users using either KB or MB.

Created and maintained by **Akaeid Hasan**, WordPress Developer focused on WordPress, Elementor, WooCommerce and performance-friendly website development.

**Website:** https://akaeidhasan.com/  
**Author:** Akaeid Hasan  
**License:** GPL-2.0-or-later

## Why UploadShield?

Large image uploads can consume unnecessary server storage and make it easier for unoptimized media to enter a WordPress website. UploadShield adds a simple upload guard directly inside WordPress so site administrators can define practical image-size limits without editing theme files or adding custom snippets manually.

## Features

- Set a maximum image upload size for administrators.
- Set a separate maximum image upload size for other WordPress users.
- Choose **KB** or **MB** for each image limit.
- Disable either upload restriction when unrestricted image uploads are needed.
- Block oversized images before WordPress moves them into the Media Library.
- Show a clear upload error with the allowed size and the uploaded image size.
- Leave non-image file uploads untouched.
- Clean, responsive settings interface inside WordPress admin.
- Lightweight implementation with no frontend scripts, badges or branding.
- Small author/support banner only inside the UploadShield settings screen.
- Dismissible admin support reminder on a fixed 15-day cycle.
- No analytics, tracking or automatic data transmission to external services.

## Default Image Upload Limits

After activation, UploadShield starts with:

| User type | Default maximum image size |
| --- | ---: |
| Administrators | 300 KB |
| Other users | 300 KB |

You can change these values from **WordPress Dashboard → Settings → UploadShield**.

## Example

If the administrator limit is set to **300 KB** and an administrator attempts to upload a **750 KB** image, UploadShield blocks the upload and displays an error explaining the maximum allowed image size and the size of the uploaded image.

## Installation

1. Download the latest UploadShield release ZIP.
2. Open **WordPress Dashboard → Plugins → Add New Plugin → Upload Plugin**.
3. Select the UploadShield ZIP and activate the plugin.
4. Go to **Settings → UploadShield**.
5. Set the preferred administrator and other-user image upload limits.
6. Save the settings.

## How It Works

UploadShield uses the WordPress `wp_handle_upload_prefilter` filter to inspect an image before WordPress moves the uploaded file to its final uploads directory. If the image exceeds the configured limit for the current user, UploadShield returns a WordPress upload error and stops that image from being accepted.

The plugin is designed to control **WordPress image upload size**, not the server-wide PHP upload limit. If the hosting server has a lower `upload_max_filesize` or other server restriction, the server limit still applies.

## Use Cases

UploadShield can be useful for:

- WordPress websites managed by multiple administrators or editors.
- Client websites where very large images are frequently uploaded.
- Blogs and business websites that want more consistent media-library file sizes.
- Development workflows where image upload rules should be configurable from the WordPress dashboard.
- WordPress maintenance setups where oversized media needs to be blocked before upload.

## Compatibility

- **WordPress:** 6.0+
- **PHP:** 7.4+
- Uses the standard WordPress media upload pipeline.

## Privacy

UploadShield does not include analytics or tracking code and does not automatically send website data to Akaeid Hasan or any external service. External links in the admin support area are opened only when an administrator chooses to click them.

## Project Structure

```text
upload-shield/
├── assets/
│   ├── css/
│   │   └── admin.css
│   └── js/
│       └── admin.js
├── includes/
│   ├── class-admin-branding.php
│   ├── class-plugin.php
│   ├── class-settings.php
│   └── class-upload-limiter.php
├── CHANGELOG.md
├── LICENSE
├── README.md
├── readme.txt
├── uninstall.php
└── upload-shield.php
```

## Contributing

Bug reports, improvement suggestions and pull requests are welcome. Please read [CONTRIBUTING.md](CONTRIBUTING.md) before submitting a contribution.

## Security

Please do not publish sensitive security reports in a public issue. See [SECURITY.md](SECURITY.md) for the preferred reporting method.

## Author

**Akaeid Hasan**  
WordPress Developer · Elementor · WooCommerce  
Dhaka, Bangladesh  
https://akaeidhasan.com/

## License

UploadShield is licensed under the **GNU General Public License v2.0 or later (GPL-2.0-or-later)**.
