#!/bin/bash
mkdir tmp
cd tmp
git clone git://github.com/c9s/GenPHP.git
cd GenPHP
./genphp install flavors/flavor
mkdir ~/bin
mkdir -p ~/.genphp/flavors
cp -v genphp ~/bin
if [[ -e ~/.zshrc ]] ; then
    echo "export PATH=\$PATH:~/bin" >> ~/.zshrc
    source ~/.zshrc
elif [[ -e ~/.bashrc ]] ; then
    echo "export PATH=\$PATH:~/bin" >> ~/.bashrc
    source ~/.bashrc
fi
echo "Done"
