function log () {
  timestamp=$(date +"%Y-%m-%d %T")
  echo "["$timestamp"] "$1
}

log "This is a test log message!"
