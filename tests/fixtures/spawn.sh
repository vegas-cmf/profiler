#!/bin/bash

# Simple server spawner. Binds to 8080 port by default.
# Has to be run from the current working directory.

# Used for manual application testing.

# First recreate database file.
cat db/schema.sqlite | sqlite3 db/test.db

if [ ! -z "$1" ]; then
    SRV_PORT="$1"
else
    SRV_PORT=8080
    echo "Server port not provided, using ${SRV_PORT}"
fi

php -S 127.0.0.1:${SRV_PORT} -t public/ public/startup.php