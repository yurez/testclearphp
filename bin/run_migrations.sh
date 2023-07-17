#!/bin/bash

# Змінюємо права доступу до файлу .env
chmod +x .env

# Завантажуємо змінні оточення з файлу .env
source .env

MIGRATIONS_DIR="migrations"

# Перевіряємо чи існує папка з міграціями
if [ ! -d "$MIGRATIONS_DIR" ]; then
  echo "Папка з міграціями не знайдена: $MIGRATIONS_DIR"
  exit 1
fi

# Перебираємо всі файли SQL у папці міграцій
for migration_file in "$MIGRATIONS_DIR"/*.sql; do
  # Виконуємо SQL-запит з кожного файла
  mysql -h "$MYSQL_HOST" -P "$MYSQL_PORT" -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < "$migration_file"
  # Перевіряємо код виходу mysql, якщо не дорівнює 0, то припиняємо міграції
  if [ $? -ne 0 ]; then
    echo "Помилка під час виконання міграції з файлу: $migration_file"
    exit 1
  fi
done

echo "Міграції успішно виконано!"
exit 0
