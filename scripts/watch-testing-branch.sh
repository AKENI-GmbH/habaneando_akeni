#!/usr/bin/env sh

set -eu

REPO_ROOT="$(git rev-parse --show-toplevel 2>/dev/null || true)"
if [ -z "$REPO_ROOT" ]; then
  echo "Error: must run inside a git repository." >&2
  exit 1
fi

cd "$REPO_ROOT"

STATE_DIR="${STATE_DIR:-$REPO_ROOT/.branch-watch}"
LOCK_DIR="$STATE_DIR/lock"
SHA_FILE="$STATE_DIR/origin-testing.sha"
LOG_FILE="$STATE_DIR/watcher.log"

mkdir -p "$STATE_DIR"

timestamp() {
  date '+%Y-%m-%dT%H:%M:%S%z'
}

log() {
  printf '%s %s\n' "$(timestamp)" "$1" | tee -a "$LOG_FILE"
}

if ! mkdir "$LOCK_DIR" 2>/dev/null; then
  log "Another watcher run is in progress; skipping."
  exit 0
fi

cleanup() {
  rmdir "$LOCK_DIR" >/dev/null 2>&1 || true
}
trap cleanup EXIT INT TERM

if ! command -v git >/dev/null 2>&1; then
  log "git is not available in PATH."
  exit 1
fi

if ! command -v docker >/dev/null 2>&1; then
  log "docker is not available in PATH."
  exit 1
fi

if ! docker info >/dev/null 2>&1; then
  log "Docker daemon is not available."
  exit 1
fi

if ! git fetch --quiet origin testing; then
  log "Failed to fetch origin/testing."
  exit 1
fi

remote_sha="$(git rev-parse --verify origin/testing 2>/dev/null || true)"
if [ -z "$remote_sha" ]; then
  log "Could not resolve origin/testing SHA."
  exit 1
fi

if [ ! -f "$SHA_FILE" ]; then
  printf '%s\n' "$remote_sha" > "$SHA_FILE"
  log "Initialized watcher state at SHA=$remote_sha (no restart on first run)."
  exit 0
fi

previous_sha="$(cat "$SHA_FILE" 2>/dev/null || true)"

if [ "$remote_sha" = "$previous_sha" ]; then
  log "No upstream change detected on origin/testing (SHA=$remote_sha)."
  exit 0
fi

log "Change detected on origin/testing: $previous_sha -> $remote_sha. Rebuilding app+web."
if docker compose -f docker-compose.dev.yml up -d --build app web; then
  printf '%s\n' "$remote_sha" > "$SHA_FILE"
  log "Rebuild/restart successful. Updated tracked SHA to $remote_sha."
  exit 0
fi

log "Docker rebuild/restart failed. Keeping previous tracked SHA=$previous_sha."
exit 1
