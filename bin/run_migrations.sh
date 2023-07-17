#!/bin/bash

chmod +x .env

source .env

MIGRATIONS_DIR="migrations"

if [ ! -d "$MIGRATIONS_DIR" ]; then
  echo "Migration folder not found: $MIGRATIONS_DIR"
  exit 1
fi

for migration_file in "$MIGRATIONS_DIR"/*.sql; do
  mysql -h "$MYSQL_HOST" -P "$MYSQL_PORT" -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < "$migration_file"
  if [ $? -ne 0 ]; then
    echo "Failed migration in file: $migration_file"
    exit 1
  fi
done

echo "Migration success!"
exit 0
