#!/usr/bin/env bash

if [ -f bitforces.zip ]; then
  rm bitforces.zip
fi

# write commit count since release into version number when compiling into zip
count=$(git log $(git describe --tags --abbrev=0)..HEAD --oneline | wc -l)
if [ ${count} \> 0 ];
then
    sed -i -E 's/return "([0-9]+)\.([0-9]+)\.([0-9]+)"/return "\1.\2.\3.'$count'"/g' client/initialize.py
fi;
zip -r bitforces.zip __main__.py client -x "*__pycache__*"
if [ ${count} \> 0 ];
then
    sed -i -E 's/return "([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)"/return "\1.\2.\3"/g' client/initialize.py
fi;