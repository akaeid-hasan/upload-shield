# UploadShield — WordPress Image Upload Size Limit Plugin

**UploadShield** is a lightweight WordPress image upload size limit plugin that blocks oversized images before they enter the WordPress Media Library. Administrators can set separate maximum image upload limits for administrators and other WordPress users, using either **KB** or **MB**.

Created and maintained by **[Akaeid Hasan](https://akaeidhasan.com/)**, a WordPress Developer focused on WordPress, Elementor, WooCommerce, and performance-friendly website development.

[Download UploadShield](https://github.com/akaeid-hasan/upload-shield/releases) · [Report an Issue](https://github.com/akaeid-hasan/upload-shield/issues) · [Author Website](https://akaeidhasan.com/)

| Plugin information | Details |
| --- | --- |
| Plugin name | UploadShield |
| Purpose | WordPress image upload size control |
| Author | Akaeid Hasan |
| WordPress | 6.0+ |
| PHP | 7.4+ |
| License | GPL-2.0-or-later |
| Website | [akaeidhasan.com](https://akaeidhasan.com/) |

## Table of Contents

- [Why UploadShield?](#why-uploadshield)
- [Features](#features)
- [Administrator and Other-User Controls](#administrator-and-other-user-controls)
- [Default Image Upload Limits](#default-image-upload-limits)
- [Installation](#installation)
- [Configuration](#configuration)
- [Example: Blocking an Oversized Image](#example-blocking-an-oversized-image)
- [How It Works](#how-it-works)
- [WordPress Media Library Protection](#wordpress-media-library-protection)
- [Who Is UploadShield For?](#who-is-uploadshield-for)
- [Common Use Cases](#common-use-cases)
- [UploadShield vs. Server Upload Limits](#uploadshield-vs-server-upload-limits)
- [Image Optimization and Frontend Behavior](#image-optimization-and-frontend-behavior)
- [Compatibility](#compatibility)
- [Privacy and Admin Support Information](#privacy-and-admin-support-information)
- [Frequently Asked Questions](#frequently-asked-questions)
- [Technical Information](#technical-information)
- [Project Structure](#project-structure)
- [Releases and Changelog](#releases-and-changelog)
- [Development Philosophy](#development-philosophy)
- [Contributing](#contributing)
- [Security](#security)
- [Author: Akaeid Hasan](#author-akaeid-hasan)
- [Support UploadShield](#support-uploadshield)
- [License](#license)

## Why UploadShield?

Large image uploads can consume unnecessary server storage and make it easier for unoptimized media to enter a WordPress website.

UploadShield adds an upload guard directly inside WordPress. Site administrators can define practical image file-size limits without editing theme files or manually adding custom snippets.

It is particularly useful when clients, editors, or multiple administrators manage website content and need a consistent image upload policy.

## Features

- Set a maximum image upload size for administrators.
- Set a separate maximum image upload size for other WordPress users.
- Choose **KB** or **MB** for each image limit.
- Disable either upload restriction when unrestricted image uploads are needed.
- Block oversized images before WordPress moves them into the Media Library.
- Show a clear upload error with the allowed size and the uploaded image size.
- Leave non-image file uploads untouched.
- Clean, responsive settings interface inside WordPress admin.
- Lightweight implementation with no frontend scripts, badges, or branding.
- Small author/support banner only inside the UploadShield settings screen.
- Dismissible admin support reminder on a fixed **15-day cycle**.
- No analytics, tracking, or automatic data transmission to external services.

## Administrator and Other-User Controls

UploadShield provides two independently controlled image upload limits: one for administrators and another for other WordPress users.

For example:

```text
Administrator Maximum Image Size: 1 MB
Other Users Maximum Image Size: 300 KB
```

This allows administrators to use a larger allowance while other users follow a stricter limit. The other-user setting applies to users who already have permission to upload through the applicable WordPress workflow; it does not grant upload permissions.

### Enable or Disable Individual Limits

Either restriction can be disabled independently. Disabling an UploadShield restriction does not remove server limits or other WordPress upload checks.

### Clean WordPress Admin Interface

The settings screen brings together administrator limits, other-user limits, image size values, KB/MB controls, and protection status in a responsive interface.

## Default Image Upload Limits

After activation, UploadShield starts with:

| User type | Default maximum image size |
| --- | --- |
| Administrators | 300 KB |
| Other users | 300 KB |

Change these values from **WordPress Dashboard → Settings → UploadShield**.

## Installation

1. Download the latest UploadShield release ZIP from [GitHub Releases](https://github.com/akaeid-hasan/upload-shield/releases).
2. Open **WordPress Dashboard → Plugins → Add New Plugin → Upload Plugin**.
3. Select the UploadShield ZIP and click **Install Now**.
4. Activate **UploadShield**.
5. Go to **Settings → UploadShield**.
6. Set the preferred administrator and other-user image upload limits.
7. Save the settings.

## Configuration

Open **WordPress Dashboard → Settings → UploadShield** to configure each group's image file-size limit, select KB or MB, and enable or disable the applicable restriction.

Example configurations:

| Configuration | Administrator limit | Other-user limit |
| --- | --- | --- |
| Example 1 | 500 KB | 300 KB |
| Example 2 | 1 MB | 300 KB |
| Example 3 | 2 MB | 1 MB |

Choose values that suit your website's publishing workflow and image requirements, then save your settings.

## Example: Blocking an Oversized Image

If the administrator limit is set to **300 KB** and an administrator attempts to upload a **750 KB** image, UploadShield blocks the upload.

The error explains both the **maximum allowed image size** and the **uploaded image size**, helping the user understand why the file was rejected.

Similarly, an editor uploading a **2.4 MB JPEG** would be blocked when the enabled other-user limit is **500 KB**.

## How It Works

UploadShield uses the WordPress `wp_handle_upload_prefilter` filter to inspect an image before WordPress moves the uploaded file to its final uploads directory.

1. WordPress receives the uploaded file.
2. UploadShield checks whether the file is an image.
3. The plugin determines the applicable limit for the current user.
4. If that restriction is enabled, it compares the image file size with the configured maximum.
5. An image within the limit continues through WordPress's normal upload process.
6. An image above the limit receives a WordPress upload error and is not accepted.

Non-image file uploads are left untouched by UploadShield.

## WordPress Media Library Protection

UploadShield works through the standard WordPress media upload pipeline. Applicable workflows include image uploads through:

- The WordPress Media Library.
- Posts and pages.
- Featured image selectors.
- WordPress editors and standard media upload dialogs.
- Themes and plugins that use the same standard upload handling.

Third-party behavior depends on the upload implementation. A custom upload workflow that bypasses the relevant WordPress filter may not be covered.

## Who Is UploadShield For?

- WordPress developers and freelancers.
- Website agencies and maintenance teams.
- Website administrators and content teams.
- WooCommerce store owners.
- Elementor website developers.
- Client websites where users manage their own media.
- Multi-author blogs and business websites.
- Websites with limited hosting storage.

## Common Use Cases

### Client WordPress Websites

Clients may upload large images directly from a phone, camera, or design application. UploadShield blocks images that exceed the configured limit before they enter the Media Library through the supported workflow.

### Multi-Author Blogs and Business Websites

Define a consistent media policy for authors and editors with upload permissions, while keeping a separate allowance for administrators. This reduces the need to check each incoming image's file size manually.

### WooCommerce Stores

Product images, product galleries, category images, and marketing graphics can increase storage use. UploadShield can enforce image-size limits where the store's upload workflow uses standard WordPress handling.

It does not replace WooCommerce image compression or optimization tools.

### Elementor Websites

Hero sections, backgrounds, landing pages, service sections, portfolios, blog layouts, and WooCommerce templates often require image uploads.

UploadShield can restrict oversized source images when those uploads use the standard WordPress pipeline. It does not modify Elementor or add frontend Elementor widgets.

### Development and Maintenance Workflows

Keep image upload rules configurable from the WordPress dashboard and block oversized media during supported uploads as part of an ongoing website maintenance process.

## UploadShield vs. Server Upload Limits

UploadShield controls **WordPress image upload size**, not the server-wide PHP upload limit.

For example, a hosting server may allow uploads of **64 MB**, while UploadShield restricts applicable image uploads to **300 KB** or **1 MB**.

| Restriction | What it controls |
| --- | --- |
| PHP or hosting upload limit | The upload restrictions enforced by the server. |
| UploadShield image limit | An additional file-size restriction for images in the supported WordPress upload workflow. |

If the hosting server has a lower `upload_max_filesize` or another server restriction, that restriction still applies. UploadShield cannot raise or bypass it.

## Image Optimization and Frontend Behavior

### Does UploadShield Compress Images?

No. UploadShield blocks oversized images; it does not automatically:

- Compress images.
- Resize uploaded images.
- Convert JPEG to WebP.
- Convert PNG to WebP.
- Optimize existing Media Library images.
- Modify image quality.

Use a separate image optimization tool for those tasks.

### Does UploadShield Affect the Website Frontend?

UploadShield adds no frontend scripts, badges, developer branding, advertisements, credits, or promotional content. Its settings and support information are presented in the WordPress administration area.

## Compatibility

| Requirement | Supported baseline |
| --- | --- |
| WordPress | 6.0+ |
| PHP | 7.4+ |
| Upload pipeline | Standard WordPress media upload handling |

## Privacy and Admin Support Information

UploadShield does not include analytics or tracking code and does not automatically send website data to Akaeid Hasan or any external service.

External links in the admin support area are opened only when an administrator chooses to click them.

The plugin includes:

- A small author/support banner only inside the UploadShield settings screen.
- A dismissible admin support reminder on a fixed **15-day cycle**.

These support elements do not add branding to the public-facing website.

## Frequently Asked Questions

### What does UploadShield do?

It sets maximum image upload sizes in WordPress and rejects images that exceed the enabled limit for the current user group.

### Can I set a maximum image size of 300 KB?

Yes. Both user groups start with a 300 KB default limit, and you can change the values from the settings screen.

### Can I use a 1 MB upload limit?

Yes. UploadShield supports both KB and MB values.

### Can administrators have a different limit?

Yes. Administrators and other WordPress users have separate limits that can be enabled or disabled independently.

### Does UploadShield block non-image files?

No. Non-image file uploads are left untouched by the plugin.

### What does the upload error show?

The error shows the maximum allowed image size and the size of the uploaded image.

### Does it work with the WordPress Media Library?

Yes. UploadShield uses the standard WordPress media upload pipeline to inspect images before they are moved to the final uploads directory.

### Can I use it with WooCommerce or Elementor?

It can apply to image uploads that use standard WordPress handling. Coverage depends on whether the specific upload workflow passes through the relevant WordPress filter.

### Does UploadShield resize or optimize images?

No. It restricts incoming image file sizes. It does not compress, resize, convert, or optimize images already in the Media Library.

### Can I disable an upload limit?

Yes. Either restriction can be disabled independently. Server restrictions and other upload checks still apply.

### Does the plugin display frontend branding?

No. It adds no frontend scripts, badges, or branding. The support banner is limited to the UploadShield settings screen, and the dismissible support reminder appears in the administration area.

### Does UploadShield track users or send website data externally?

No. The plugin includes no analytics, tracking, or automatic data transmission to external services.

## Technical Information

The core image-size check uses `wp_handle_upload_prefilter` and does not require an external API or third-party service.

The code is separated into components for plugin initialization, upload limiting, settings, admin branding, and admin assets.

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

## Releases and Changelog

Download plugin packages from [GitHub Releases](https://github.com/akaeid-hasan/upload-shield/releases).

See [CHANGELOG.md](CHANGELOG.md) for version history and release changes.

## Development Philosophy

> Prevent unnecessarily large images before they become a WordPress media-management problem.

UploadShield stays focused on configurable image upload size limits, with a lightweight implementation and no unrelated frontend features.

## Contributing

Bug reports, improvement suggestions, and pull requests are welcome.

Please read [CONTRIBUTING.md](https://github.com/akaeid-hasan/upload-shield/blob/main/CONTRIBUTING.md) before submitting a contribution.

## Security

Please do not publish sensitive security reports in a public issue.

See [SECURITY.md](https://github.com/akaeid-hasan/upload-shield/blob/main/SECURITY.md) for the preferred reporting method.

## Author: Akaeid Hasan

**WordPress Developer · Elementor · WooCommerce**  
**Dhaka, Bangladesh**

[Akaeid Hasan](https://akaeidhasan.com/) is the creator and maintainer of UploadShield. He develops WordPress websites for businesses and individuals, with a focus on responsive design, usability, and website performance.

His work includes business websites, portfolios, blogs, landing pages, and eCommerce stores. He uses Elementor Pro for website design and customization, and WooCommerce for online store development. His frontend skills include HTML, CSS, and JavaScript.

### WordPress Development Services

- WordPress website design, development, and redesign.
- Elementor and Elementor Pro customization.
- WooCommerce store setup and customization.
- Responsive landing pages and business websites.
- Theme customization and custom WordPress functionality.
- Website speed optimization and maintenance.
- WordPress migration and troubleshooting.

UploadShield reflects his focus on practical WordPress development: giving website owners a straightforward way to manage image upload limits from their dashboard.

### Contact the Author

| Contact | Details |
| --- | --- |
| Website and portfolio | [akaeidhasan.com](https://akaeidhasan.com/) |
| GitHub | [akaeid-hasan](https://github.com/akaeid-hasan) |
| Email | [akaeidhasan.bd@gmail.com](mailto:akaeidhasan.bd@gmail.com) |
| Contact email | [contact@akaeidhasan.com](mailto:contact@akaeidhasan.com) |
| WhatsApp | [+880 1580-726459](https://wa.me/8801580726459) |

For WordPress, Elementor, or WooCommerce development inquiries, visit [Akaeid Hasan's website](https://akaeidhasan.com/). For plugin bugs and feature requests, use the [UploadShield issue tracker](https://github.com/akaeid-hasan/upload-shield/issues).

## Support UploadShield

If UploadShield helps your website or client projects, you can support it by:

- Starring the [GitHub repository](https://github.com/akaeid-hasan/upload-shield).
- Reporting bugs.
- Suggesting improvements.
- Sharing the plugin with WordPress users and developers.
- Contributing code or documentation.

## License

UploadShield is licensed under the **GNU General Public License v2.0 or later (GPL-2.0-or-later)**.

See [LICENSE](LICENSE) for the full license terms.

---

**UploadShield — WordPress Image Upload Size Limit Plugin**  
Created and maintained by **[Akaeid Hasan](https://akaeidhasan.com/)**.
