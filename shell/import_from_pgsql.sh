#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
php "${DIR}"/import_from_pgsql.php $1