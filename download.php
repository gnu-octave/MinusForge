<?php
$CACHE_FILE = "cache.txt";
$OCTAVE_PACKAGES_URL = "https://gnu-octave.github.io/packages";
$PACKAGES_DOWNLOAD_URL = "$OCTAVE_PACKAGES_URL/packages/forge-download.html";

// Just redirect if no tarball is requested.
if (! isset($_GET["file"])) {
  header("404 Not Found", true, 404);
	exit();
}

// Delete outdated cache file.
if (is_file($CACHE_FILE)) {
  if (time() - filemtime($CACHE_FILE) >= 60 * 10) {  // 10 minutes
    unlink($CACHE_FILE);
  }
}

// Recreate cache if necessary.
if (! is_file($CACHE_FILE)) {
  file_put_contents($CACHE_FILE, fopen($PACKAGES_DOWNLOAD_URL, 'r'));
}

// Find entry in cache file.
$tarball = $_GET['file'];
$str = file_get_contents($CACHE_FILE);
preg_match('/^' . $tarball . ',(.*)$/m', $str, $redirect_url);

if (! $redirect_url) {
  header("404 Not Found", true, 404);
} else {
  // Temporary redirect
  header("Location: " . $redirect_url[1], true, 307);
}
exit();
?>
