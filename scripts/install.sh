#!/bin/bash
mkdir tmp
cd tmp
git clone git://github.com/c9s/GenPHP.git
cd GenPHP
./genphp install flavors/flavor
mkdir ~/bin
cp -v genphp ~/bin
if [[ -e ~/.zshrc ]] ; then
    echo "PATH=\$PATH:~/bin" >> ~/.zshrc
    source ~/zshrc
elif [[ -e ~/.bashrc ]] ; then
    echo "PATH=\$PATH:~/bin" >> ~/.bashrc
    source ~/.bashrc
fi
echo "Done"
