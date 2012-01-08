#!/bin/bash
./scripts/compile.sh
onion.phar build
sudo pear install -f package.xml
