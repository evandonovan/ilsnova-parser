<?php

// Read a file name off the command line for parsing
if(!empty($argv[1])) {
  if(file_exists($argv[1])) {
    $fh_bin = fopen($argv[1], 'r');
    // Open a new file handle for the parsaed version.
    $filename = explode('.', $argv[1]);
    $fh_new = fopen($filename[0] . '_gift.txt', 'w+');
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
  // Get the number of responses each question has, but don't echo it.
  $num_responses = fgets($fh_bin); 
  // Write a question title
  fwrite($fh_new, '::Question ' . $question_count);
  // Get the paragraph that the questions use.
  $num_lines = fgets($fh_bin);
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $paragraph .= $line;
  }
  fwrite($fh_new, ':: ' . $paragraph);
  // Get the question (single line)
  $question = fgets($fh_bin);
  fwrite($fh_new, $question . ' {');
  // Get the default response (will not be added to Moodle)
  $num_lines = fgets($fh_bin);
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $def_response .= $line;
  }
  // Get the correct answer
  $correct_answer = fgets($fh_bin);
  fwrite($fh_new, '=' . $correct_answer);
  $num_lines = fgets($fh_bin);
  fwrite($fh_new, '#');
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $cor_response .= $line;
  }
  fwrite($fh_new, $cor_response);
  for($i = 1; $i < $num_responses; $i++) {
    get_wrong_answer($fh_bin, $fh_new, $i);
  };
  fwrite($fh_new, '}');
  // Increment the number of questions.
  $question_count++;
  // Reset the paragraph and response values.
  $paragraph = '';
  $def_response = '';
  $cor_response = '';
}

function get_wrong_answer($fh_bin, $fh_new, $i) {
  $wrong_answer = fgets($fh_bin);
  $wrong_response = '';
  fwrite($fh_new, '~ ' . $wrong_answer);
  $num_lines = fgets($fh_bin);
  fwrite($fh_new, '# ');
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $wrong_response .= $line;
  }
  fwrite($fh_new, $wrong_response);
}
?>
