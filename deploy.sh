#!/bin/bash

echo "starting deployment with Git-FTP..."

git config git-ftp.url ftp://your-host.com/app
git config git-ftp.user USER
git config git-ftp.password PASSWORD

git ftp push

echo "deployment finished!"