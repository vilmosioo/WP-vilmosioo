#!/bin/sh

echo 'Setting identity for git'
git config user.email 'ioo.vilmos@gmail.com' || { echo 'Git auth failed' ; exit 1; }
git config user.name 'Vilmos Ioo'

echo 'Patching version...'
npm version patch -m "Updating version --skip-ci" || { echo 'Version patch failed' ; exit 1; }

echo 'Test and build artefacts...'
grunt || { echo 'Grunt build failed' ; exit 1; }

echo 'SUCCESS!'
exit 0