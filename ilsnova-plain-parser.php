<?php

// Read a file name off the command line for parsing
if(!empty($argv[1])) {
  if(file_exists($argv[1])) {
    $fh_bin = fopen($argv[1], 'r');
    $filename = explode('.', $argv[1]);
    // Open a new file handle for the parsed version.
    $fh_new = fopen($filename[0] . '_parsed.txt', 'w+');
  }
  else {
    echo "The file you specified does not exist.";
  }
}
// Parse the file contents.
$at_file_start = TRUE;
// Ignore the first line.
// @todo: Figure out what it means.
fgets($fh_bin);
$question_count = 1;
$paragraph = '';
$def_response = '';
// Do parsing in a while loop until the end of the file.
while(!feof($fh_bin)) {
  // Get the paragraph that the item uses.
  $num_lines = fgets($fh_bin);
  fwrite($fh_new, 'Page ' . $question_count . ':');
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $paragraph .= $line;
  }
  fwrite($fh_new, PHP_EOL);
  fwrite($fh_new, $paragraph);
  fwrite($fh_new, PHP_EOL . PHP_EOL);
  // Increment the number of questions.
  $question_count++;
  // Reset the paragraph and response values.
  $paragraph = '';
  $def_response = '';
  $cor_response = '';
}
?>
