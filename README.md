mautic-linux
=============
Plugin to get last kernel version on mails from Mautic.

the plan
--------
I was committed to made available on message bodies dynamic content coming from existing website. Documentation how to get this work done is weak, so I had to roll up sleeves and take action.
As a generic reference, I am publishing it as the solution for getting last Linux Kernel stable version.

setup
-----
0. Copy LinuxVerBundle from repository into `/plugins`
0. Delete the cache content from `/app/cache/dev`
0. Reach plugin management from Settings or by navigating to `/s/plugins`, then click the `Install/Upgrade Plugins`
0. LinuxVer plugin with default icon should appear now on the plugins grid

usage
-----
From email Builder, a new section LinuxVer will appear, with just a `Version` button.
By dragging and dropping the token on the email body, you'll choose where the last Linux Kernel version will appear, so `{linuxver_lastver}` will be replaced with live remote data.
