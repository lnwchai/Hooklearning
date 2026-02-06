#!/bin/bash
# build-assets.sh

echo "Starting asset optimization..."

# Create dist directory
mkdir -p assets/dist

# Minify CSS files
echo "Minifying CSS files..."
npm run build:css

# Minify JS files
echo "Minifying JS files..."
npm run build:js

echo "Asset optimization complete!"