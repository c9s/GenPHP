#!/bin/bash
version=$(cat package.ini|grep version|sed -e 's/version =//')
scripts/compile.sh
onion -d build
git commit -a -m "Build Release for version $version"
