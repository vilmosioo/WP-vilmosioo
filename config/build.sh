#!/bin/sh

echo 'Test and build artefacts...'
grunt || { echo 'Grunt build failed' ; exit 1; }

echo 'SUCCESS!'
exit 0