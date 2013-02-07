<?php

// Read a file name off the command line for parsing
if(!empty($argv[1])) {
  if(file_exists($argv[1])) {
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
// Ignore the first line.
// @todo: Figure out what it means.
fgets($fh_bin);
$question_count = 1;
// Do parsing in a while loop until the end of the file.
while(!feof($fh_bin)) {
  // Get the number of responses each question has.
  $num_responses = fgets($fh_bin); 
  fwrite($fh_new, 'Number of Responses per Question: ' . $num_responses . "\n");
  $num_lines = fgets($fh_bin);
  // Get the paragraph that the questions use.
  fwrite($fh_new, 'Paragraph ' . $question_count . ':');
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $paragraph .= $line;
  }
  fwrite($fh_new, $paragraph);
  fwrite("\n");
  // Get the question (single line)
  $question = fgets($fh_bin);
  fwrite($fh_new, $question);
  fwrite("\n");
  // Get the default response (will not be added to Moodle)
  $num_lines = fgets($fh_bin);
  fwrite($fh_new, 'Default Response ' . $question_count . ':');
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $def_response .= $line;
  }
  fwrite($fh_new, $def_response);
  fwrite("\n");
  // Get the correct answer
  $correct_answer = fgets($fh_bin);
  fwrite($fh_new, 'Correct Answer: ' . $correct_answer);
  $num_lines = fgets($fh_bin);
  fwrite($fh_new, 'Correct Response: ');
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $cor_response .= $line;
  }
  fwrite($fh_new, $cor_response);
  fwrite("\n");
  get_wrong_answer($fh_bin, $fh_new, 1);
  get_wrong_answer($fh_bin, $fh_new, 2);
  get_wrong_answer($fh_bin, $fh_new, 3);
  fwrite("\n\n");
  $question_count++;
}

function get_wrong_answer($fh_bin, $fh_new, $i) {
  $wrong_answer = fgets($fh_bin);
  fwrite($fh_new, 'Wrong Answer #' . $i . ': ' . $wrong_answer);
  $num_lines = fgets($fh_bin);
  fwrite($fh_new, 'Wrong Response: ');
  for($i = 0; $i < $num_lines; $i++) {
    $line = fgets($fh_bin);
    $wrong_response .= $line;
  }
  fwrite($fh_new, $wrong_response);
  fwrite("\n");
}
?>
