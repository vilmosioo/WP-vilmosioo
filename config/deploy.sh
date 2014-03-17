#!/bin/sh

echo 'Starting deployment to server...'
grunt ftp-deploy || { echo 'FTP deployment failed.' ; exit 1; }

echo 'Pushing git data to repo...'
git push origin || { echo 'Git push failed.' ; exit 1; }
git push origin --tags || { echo 'Git tagging failed.' ; exit 1; }

echo 'SUCCESS!'
exit 0