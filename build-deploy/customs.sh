#!/usr/bin/env bash

# Run custom commands
for file in build-deploy/run/*; do
    [ -f "$file" ] && [ -x "$file" ] && "$file"
done
