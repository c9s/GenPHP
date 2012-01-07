#!/bin/bash
onion.phar -d compile \
    --lib src \
    --lib vendor/pear \
    --classloader \
    --bootstrap scripts/genphp \
    --executable \
    --output genphp
