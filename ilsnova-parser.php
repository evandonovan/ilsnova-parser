<?php

// Read a file name off the command line for parsing
if(!empty($argv[1]) {
  if(file_exists($argv[1]) {
    $fh_bin = fopen($argv[1], 'r');
    // Open a new file handle for the parsaed version.
    $fh_new = fopen($argv[1] . '_parsed.txt', 'w+');
  }
  else {
    echo "The file you specified does not exist.";
  }
}
// Parse the file contents.
$at_file_start = TRUE;
fgets($fh_bin);
  $question_count = 1;
while(!feof($fh_bin)) {
  $num_questions = fgets($fh_bin);
  fwrite($fh_new, 'Number of Questions: ' . $num_questions . '\n');
  $num_lines = fgets($fh_bin);
  fwrite($fh_new, 'Question #' . $question_count . ':');
  for($i = 0; $i > $num_lines; $i++) {
    $line = fgets($fh_bin);
    $question .= $line;
  }
  fwrite($fh_new, $question);
  $question_count++;
}
?>
