#!/bin/bash
mkdir -p /var/tmp
cd /var/tmp

if [[ -e GenPHP ]] ; then
    cd GenPHP
    git remote update --prune
    git pull origin master
else
    git clone git://github.com/c9s/GenPHP.git
    cd GenPHP
fi
./genphp install flavors/flavor
mkdir -p ~/bin
mkdir -p ~/.genphp/flavors
cp -v genphp ~/bin
if [[ -e ~/.zshrc && -z $(grep GenPHP ~/.zshrc) ]] ; then
    echo "# GenPHP" >> ~/.zshrc
    echo "export PATH=\$PATH:~/bin" >> ~/.zshrc
elif [[ -e ~/.bashrc ]] ; then
    echo "# GenPHP" >> ~/bashrc
    echo "export PATH=\$PATH:~/bin" >> ~/.bashrc
fi
echo "Done"
echo ""
echo "Please reload your bashrc or zshrc"
echo ""
echo "To list genphp flavors:"
echo "    \$ genphp list "
echo ""
echo "To create new flavor:"
echo "    \$ genphp new flavor YourFlavor"
echo ""
echo "Enjoy!"
