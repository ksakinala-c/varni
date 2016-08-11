#!/bin/bash
#
# This (hackish..) script is used to update a local deployment of the client
# area's files from the Git repository.
#
# Update BASE_DIRECTORY below to the parent directory of your web server's
# document root. If needed update the REPO_DIRECTORY too.
#

BASE_DIRECTORY=/var/www/html/xvarnish                      # top level path of deploy (one directory above HTTP document root)
REPO_DIRECTORY="${BASE_DIRECTORY}/xVarnish-Clients"        # this should be the checked-out or cloned repository directory that exists in ./repo/



# the below variables shouldn't need to be updated, but I tried to comment the script if you need to make any changes

DOCROOT_NAME=public_html                                # location for CodeIgniter index.php, static assets
CI_NAME=ci                                              # location for CodeIgniter system/ and application/
SITE_CONFIG_DIRECTORY=site-config                       # name of directory containing deploy-specific files (containing configurations, passwords)
REPO_TYPE=git                                           # top level path of deploy (one directory above HTTP document root)

BASE_EXPORT="${BASE_DIRECTORY}/export/"
EXPORT_DOCROOT="${BASE_EXPORT}${DOCROOT_NAME}"
EXPORT_CI="${BASE_EXPORT}${CI_NAME}"


# GO GO GO

if [ -d "${BASE_DIRECTORY}" ]
then
                cd $BASE_DIRECTORY
else
                echo "error: base directory ${BASE_DIRECTORY} does not exist"
                exit
fi

# clean up past leftovers (if something went wrong in the past run)
if [ -d "${BASE_EXPORT}" ]
then
                if [[ -d "${EXPORT_DOCROOT}" || -d "${EXPORT_CI}" ]]
                then
                                echo "warning: removing leftover export directory"
                                cd $BASE_DIRECTORY
                                find export -mindepth 1 -delete  # hardcoded 'export' dirname for safety
                fi
else
                mkdir -p "${BASE_EXPORT}"
fi

if [ ! -d "${REPO_DIRECTORY}" ]
then
                echo "error: checked-out/cloned repository in ${REPO_DIRECTORY} doesn't exist"
                exit
fi


echo "exporting repository: ${REPO_DIRECTORY} to ${BASE_EXPORT}"
if [ "${REPO_TYPE}" == "git" ]
then
                # git rc
                cd $REPO_DIRECTORY
                git pull
                cd src
                git checkout-index --prefix=$BASE_EXPORT -a

                cd $BASE_EXPORT
                mv src/ci ci
                mv src/public_html public_html
                rmdir src

elif [ "${REPO_TYPE}" == "svn" ]
then
                # svn rc
                cd $REPO_DIRECTORY
                svn update
                cd src
                svn export --force . $BASE_EXPORT
else
                echo "error: invalid revision control type: ${RC_TYPE}"
                exit
fi

# run composer update
if [ -f "$REPO_DIRECTORY/composer/composer.json" ]
then
                mkdir -p $BASE_DIRECTORY/composer-update

                echo "copying composer executable and composer.json to $BASE_DIRECTORY/composer-update"
                \cp --force $REPO_DIRECTORY/composer/composer.phar $BASE_DIRECTORY/composer-update/composer.phar
                \cp --force $REPO_DIRECTORY/composer/composer.json $BASE_DIRECTORY/composer-update/composer.json

                echo "running composer update in $BASE_DIRECTORY/composer-update/"
                chmod +x $BASE_DIRECTORY/composer-update/composer.phar
                cd $BASE_DIRECTORY/composer-update/
                php $BASE_DIRECTORY/composer-update/composer.phar update

                # this creates composer-update/vendor/* which we will copy to our codeigniter's third_party directory
                # it is then loaded there by library X10_Composer via its normal autoload.php

				if [ -d "$EXPORT_CI/application/third_party/vendor" ]; then
					rm -rf $EXPORT_CI/application/third_party/vendor
				fi

                \cp --force -R $BASE_DIRECTORY/composer-update/vendor $EXPORT_CI/application/third_party/vendor
fi


SITECFG_DIR=$BASE_DIRECTORY/$SITE_CONFIG_DIRECTORY
if [ -d "${SITECFG_DIR}" ]
then
                echo "copying deploy config $SITECFG_DIR/$CI_NAME to $EXPORT_CI"
                \cp --force -R $SITECFG_DIR/$CI_NAME/* $EXPORT_CI

                echo "copying deploy config $SITECFG_DIR/$DOCROOT_NAME/ to $EXPORT_DOCROOT"
                \cp --force -R $SITECFG_DIR/$DOCROOT_NAME/* $EXPORT_DOCROOT
                \cp --force $SITECFG_DIR/$DOCROOT_NAME/.htaccess $EXPORT_DOCROOT/       # recursive copy above doesn't get .htaccess
else
                echo "error: site-config directory ${SITECFG_DIR} does not exist!"
                exit
fi

# fix owner
cd $BASE_DIRECTORY
chown -R nobody.nobody "${EXPORT_DOCROOT}" "${EXPORT_CI}"

# make a quick backup of the prior ci and public_html directories in case something goes wrong
cd $BASE_DIRECTORY
mkdir -p backup
if [ -d "${BASE_DIRECTORY}/backup/${DOCROOT_NAME}-bk" ]
then

                rm -rf "${BASE_DIRECTORY}/backup/${DOCROOT_NAME}-bk"
                rm -rf "${BASE_DIRECTORY}/backup/${CI_NAME}-bk"
fi

if [ -d "public_html" ]
then
                mv "${BASE_DIRECTORY}/${DOCROOT_NAME}" "${BASE_DIRECTORY}/backup/${DOCROOT_NAME}-bk"
                mv "${BASE_DIRECTORY}/${CI_NAME}" "${BASE_DIRECTORY}/backup/${CI_NAME}-bk"
fi

# rename the newly exported and built website directories to be live
mv $EXPORT_CI $BASE_DIRECTORY/$CI_NAME
mv $EXPORT_DOCROOT $BASE_DIRECTORY/$DOCROOT_NAME

echo

# smarty permissions
mkdir -p $BASE_DIRECTORY/$CI_NAME/application/cache/smarty/compiled
chmod -R 777 $BASE_DIRECTORY/$CI_NAME/application/cache/smarty/compiled

if [ -d "$BASE_DIRECTORY/$CI_NAME/application/cache/smarty-compiled" ]
then
                chmod -R 777 $BASE_DIRECTORY/$CI_NAME/application/cache/smarty-compiled
                chmod -R 777 $BASE_DIRECTORY/$CI_NAME/application/cache/smarty-cached
fi

echo "completed deploy update from repository"
