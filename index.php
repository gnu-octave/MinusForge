<?php
$CACHE_FILE = "cache.txt";
$OCTAVE_PACKAGES_URL = "https://gnu-octave.github.io/packages/packages/forge-download.html";

// Delete outdated cache file.
if (is_file($CACHE_FILE)) {
  if (time() - filemtime($CACHE_FILE) >= 60 * 60 * 24) {  // 1 day
    unlink($CACHE_FILE);
  }
}

// Recreate cache if necessary.
if (! is_file($CACHE_FILE)) {
  file_put_contents($CACHE_FILE, fopen($OCTAVE_PACKAGES_URL, 'r'));
}

// Find entry in cache file.
$tarball = $_GET['file'];
$str = file_get_contents($CACHE_FILE);
preg_match('/^' . $tarball . ',(.*)$/m', $str, $redirect_url);

if (! $redirect_url) {
  header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
} else {
  // Temporary redirect
  header("Location: " . $redirect_url[1], true, 307);
}
exit();
?>
