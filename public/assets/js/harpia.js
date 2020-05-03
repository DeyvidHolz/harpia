function redirect(path, newTab = false) {
  return newTab ? window.open(path) : window.location.href = path;
}