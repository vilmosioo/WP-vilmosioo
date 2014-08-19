#!/bin/sh

echo 'Starting deployment to server...'
grunt ftp-deploy:prod || { echo 'FTP deployment failed.' ; exit 1; }

echo 'Pushing git data to repo...'
git push origin master || { echo 'Git push failed.' ; exit 1; }
git push origin master --tags || { echo 'Git tagging failed.' ; exit 1; }

echo 'SUCCESS!'
exit 0