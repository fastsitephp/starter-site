#!/usr/bin/env bash

# -----------------------------------------------------------------------------
#
#  This is a Bash Script that runs on the production server is used to sync
#  the latest changes for a site.
#
#  This script is a template and can be used as a starting point if you would
#  like to use this workflow for your site. For example if you publish to a
#  Git Repository this script can be modified to sync the server with your
#  published code.
#
#  To run:
#      bash /var/www/scripts/sync-server.sh
#
#  For testing with [rsync] use [-n = --dry-run]
#  Example:
#      rsync -nrcv --delete ~/starter-site-master/app/ /var/www/app
#
#
#  Various versions of this script exist and are used on a number of sites:
#      https://github.com/fastsitephp/fastsitephp/blob/master/scripts/sync-server-from-github.sh
#      https://github.com/fastsitephp/playground/blob/master/scripts/sync-server-from-github.sh
#      https://github.com/dataformsjs/website/blob/master/scripts/sync-server-from-github.sh
#      https://github.com/dataformsjs/playground/blob/master/scripts/sync-server-from-github.sh
#
# -----------------------------------------------------------------------------

echo 'This is a template bash script. Comment out the exit statement'
echo 'to see how this file works or modify for your site.'
exit

# [cd] is included in case this script runs directory from the [/var/www/scripts] dir.
# If that happens and [cd] is not included then a duplicate version of the site will
# be downloaded to the [scripts] dir.

cd ~
wget https://github.com/fastsitephp/starter-site/archive/master.zip -O ~/master.zip
unzip -q ~/master.zip
rm ~/master.zip
rsync -rcv --delete ~/starter-site-master/app/ /var/www/app
rsync -rcv --delete --exclude .env --exclude users.sqlite ~/starter-site-master/app_data/ /var/www/app_data
rsync -rcv --delete --exclude Web.config --exclude .htaccess --exclude index.php ~/starter-site-master/public/ /var/www/html
rsync -rcv --delete ~/starter-site-master/scripts/ /var/www/scripts
rm -r ~/starter-site-master

# Uncomment to update the FastSitePHP Framework
#
# wget https://github.com/fastsitephp/fastsitephp/archive/master.zip -O ~/master.zip
# unzip -q ~/master.zip
# rm ~/master.zip
# rsync -rcv --delete ~/fastsitephp-master/src/ /var/www/vendor/fastsitephp/src
# rm -r ~/fastsitephp-master
