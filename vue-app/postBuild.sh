#!/bin/sh

echo "Perform cleanup, renaming/replacing for shipping the min.js file"
cd ..
cd assets || exit
cd js || exit
cd app || exit

rm demo.html app.umd.js app.umd.js.map app.umd.min.js.map app.common.js app.common.js.map

#This hasn't been tested with the GNU version of sed, only BSD - should work though..
if "$uname" == "Darwin" ; then
 echo "Search and replace on Mac"
 sed -i "" -e 's/app.umd.min/app.umd/g' app.umd.min.js
 sed -i "" -e 's/sourceMappingURL=app.umd.js.map//g' app.umd.min.js
else
 echo "Search and replace on Linux"
 sed -i -e 's/app.umd.min/app.umd/g' app.umd.min.js
 sed -i -e 's/sourceMappingURL=app.umd.js.map//g' app.umd.min.js
fi

mv app.umd.min.js app.umd.js

echo "The minified js file is production ready"