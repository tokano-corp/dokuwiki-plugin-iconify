# Iconify Plugin for Dokuwiki

This plugin allows you to easily insert [Iconify](https://iconify.design) icons into your Dokuwiki pages using a simple syntax.

## Documentation

All documentation for this plugin can be found at
http://www.dokuwiki.org/plugin:iconify

## Installation

Search and install the plugin using the Extension Manager https://www.dokuwiki.org/plugin:extension.
If you install this plugin manually, make sure it is installed in
lib/plugins/iconify/ - if the folder is called different it
will not work!

Please refer to http://www.dokuwiki.org/extensions for additional info
on how to install extensions in DokuWiki.

## Configuration

### Default Icon Size
You can configure a default size for icons (e.g., `32px`) in the plugin settings. Default size is `24px`.

### Local or Online Mode
You can choose between loading the Iconify library from the internet or using a local file:

- **Local Mode:** Place the `iconify.min.js` file in the `lib/plugins/iconify/local/` folder. Enable the "Use local file" option in the plugin settings.
- **Online Mode:** The plugin will load the library from the internet using the version specified in the settings or fetch the latest version dynamically.

If the local mode is enabled but the file is not found, the plugin will log an error.

### Iconify Version for Online Mode
You can configure the version of the Iconify library via the plugin settings. Specify the desired version (e.g., `3.1.1`) or use `latest` to dynamically fetch the most recent version from the CDNJS API.

If the `latest` option is selected, the plugin will fetch the latest version available on CDNJS at runtime.

In case of an error with the API, the plugin will fall back to version `3.1.1`.

Go to the plugin settings page in the Dokuwiki admin panel to configure these options.

## License

Copyright (C) Tokano <contact@tokano.fr>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; version 2 of the License

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

See the LICENSING file for details
