#!/bin/sh

echo 'Starting deployment to server...'
grunt ftp-deploy:dev || { echo 'FTP deployment failed.' ; exit 1; }

echo 'SUCCESS!'
exit 0