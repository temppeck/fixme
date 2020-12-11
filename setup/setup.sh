#!/bin/bash

echo "Setting up database"
mysql --user=root --password=root < setup/create_db.sql

echo "Finished..."
