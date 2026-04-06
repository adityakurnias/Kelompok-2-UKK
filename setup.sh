#!/usr/bin/env bash

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "============================================"
echo "  Running composer setup for all projects"
echo "============================================"
echo

for DIR in "$ROOT"/*/; do
    PROJECT="$(basename "$DIR")"

    # Skip hidden folders (starting with .)
    if [[ "$PROJECT" == .* ]]; then
        continue
    fi

    echo "[*] Project: $PROJECT"
    echo "    Path: $DIR"

    if [ -f "$DIR/composer.json" ]; then
        pushd "$DIR" > /dev/null
        echo "    Running composer setup..."
        if composer run setup; then
            echo "    [OK] Done."
        else
            echo "    [FAILED] composer setup failed for $PROJECT"
        fi
        popd > /dev/null
    else
        echo "    [SKIP] No composer.json found, skipping."
    fi

    echo
done

echo "============================================"
echo "  All projects processed."
echo "============================================"
