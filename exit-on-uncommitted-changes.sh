#!/bin/bash
pwd
if [ -n "$(git status --porcelain)" ]; then
    echo "There are uncommitted changes in working tree"
    echo "Perform git status"
    git status
    echo "Exiting..."
    exit 1
else
    echo "Git working tree is clean"
fi