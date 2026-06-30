#!/usr/bin/env bash
# Usage: ./scripts/set-origin-and-push.sh [GIT_URL]
# URL order: argument > GITHUB_ORIGIN env > .private/github_remote (first non-comment line)
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

URL="${1:-${GITHUB_ORIGIN:-}}"
if [[ -z "$URL" && -f "$ROOT/.private/github_remote" ]]; then
  URL="$(grep -v '^#' "$ROOT/.private/github_remote" | grep -v '^[[:space:]]*$' | head -1 | tr -d '\r')"
fi

if [[ -z "$URL" ]]; then
  echo "No URL. Pass as arg, set GITHUB_ORIGIN, or create .private/github_remote (see .private/github_remote.example)." >&2
  exit 1
fi

if git remote get-url origin &>/dev/null; then
  git remote set-url origin "$URL"
else
  git remote add origin "$URL"
fi

git push -u origin main
