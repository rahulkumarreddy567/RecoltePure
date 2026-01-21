#!/bin/bash
set -e

# Robust cleanup of conflicting MPM modules
echo "Cleaning up MPM modules..."
rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf
rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf
rm -f /etc/apache2/mods-enabled/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.conf

# Force enable ONLY mpm_prefork
echo "Enabling mpm_prefork..."
a2enmod mpm_prefork

echo "Starting Apache..."
exec apache2-foreground
