<?php

//UTF8-sampler: Τη γλώσσα μου έδωσαν ελληνική	
/******************************************************************************
 MachForm
  
 Copyright 2007 Appnitro Software. This code cannot be redistributed without
 permission from http://www.appnitro.com/
 
 More info at: http://www.appnitro.com/
 ******************************************************************************/
 	
 	//this function simply generate a pair of question and answer array
 	function mf_get_text_captcha(){
 		$captcha_text[0]['question'] = '2 + 2 = ?';
 		$captcha_text[0]['answer']	 = '4';

 		$captcha_text[1]['question'] = '5 + 3 = ?';
 		$captcha_text[1]['answer']	 = '8';

 		$captcha_text[2]['question'] = '2 + 4 = ?';
 		$captcha_text[2]['answer']	 = '6';

 		$captcha_text[3]['question'] = '6 + 2 = ?';
 		$captcha_text[3]['answer']	 = '8';

 		$captcha_text[4]['question'] = '8 + 1 = ?';
 		$captcha_text[4]['answer']	 = '9';

 		$captcha_text[5]['question'] = '7 + 1 = ?';
 		$captcha_text[5]['answer']	 = '8';

 		$captcha_text[6]['question'] = '3 + 4 = ?';
 		$captcha_text[6]['answer']	 = '7';

 		$captcha_text[7]['question'] = '4 + 2 = ?';
 		$captcha_text[7]['answer']	 = '6';

 		$captcha_text[8]['question'] = '2 + 3 = ?';
 		$captcha_text[8]['answer']	 = '5';

 		$captcha_text[9]['question'] = '1 + 2 = ?';
 		$captcha_text[9]['answer']	 = '3';

 		$captcha_text[10]['question'] = 'What is the sum of 2 and 2 ?';
 		$captcha_text[10]['answer']	  = '4';

 		$captcha_text[11]['question'] = 'What is the sum of 5 and 3 ?';
 		$captcha_text[11]['answer']	  = '8';

 		$captcha_text[12]['question'] = 'What is the sum of 2 and 4 ?';
 		$captcha_text[12]['answer']	  = '6';

 		$captcha_text[13]['question'] = 'What is the sum of 6 and 2 ?';
 		$captcha_text[13]['answer']	  = '8';

 		$captcha_text[14]['question'] = 'What is the sum of 8 and 1 ?';
 		$captcha_text[14]['answer']	  = '9';

 		$captcha_text[15]['question'] = 'What is the sum of 7 and 1 ?';
 		$captcha_text[15]['answer']	  = '8';

 		$captcha_text[16]['question'] = 'What is the sum of 3 and 4 ?';
 		$captcha_text[16]['answer']	  = '7';

 		$captcha_text[17]['question'] = 'What is the sum of 4 and 2 ?';
 		$captcha_text[17]['answer']	  = '6';

 		$captcha_text[18]['question'] = 'What is the sum of 2 and 3 ?';
 		$captcha_text[18]['answer']	  = '5';

 		$captcha_text[19]['question'] = 'What is the sum of 1 and 2 ?';
 		$captcha_text[19]['answer']	  = '3';

 		$captcha_text[20]['question'] = 'The last letter in "rocket" is?';
 		$captcha_text[20]['answer']	  = 't';

 		$captcha_text[21]['question'] = 'The last letter in "computer" is?';
 		$captcha_text[21]['answer']	  = 'r';

 		$captcha_text[22]['question'] = 'The last letter in "train" is?';
 		$captcha_text[22]['answer']	  = 'n';

 		$captcha_text[23]['question'] = 'The last letter in "airplane" is?';
 		$captcha_text[23]['answer']	  = 'e';

 		$captcha_text[24]['question'] = 'The first letter in "morning" is?';
 		$captcha_text[24]['answer']	  = 'm';

 		$captcha_text[25]['question'] = 'The first letter in "earth" is?';
 		$captcha_text[25]['answer']	  = 'e';

 		$captcha_text[26]['question'] = 'The first letter in "moon" is?';
 		$captcha_text[26]['answer']	  = 'm';

 		$captcha_text[27]['question'] = 'The first letter in "elephant" is?';
 		$captcha_text[27]['answer']	  = 'e';

 		$captcha_text[28]['question'] = 'The first letter in "bird" is?';
 		$captcha_text[28]['answer']	  = 'b';

 		$captcha_text[29]['question'] = 'The last letter in "tiger" is?';
 		$captcha_text[29]['answer']	  = 'r';

 		$captcha_text[30]['question'] = 'In the number 73627, what is the 3rd digit?';
 		$captcha_text[30]['answer']	  = '6';

 		$captcha_text[31]['question'] = 'In the number 91723, what is the 2nd digit?';
 		$captcha_text[31]['answer']	  = '1';

 		$captcha_text[32]['question'] = 'In the number 73628, what is the 4th digit?';
 		$captcha_text[32]['answer']	  = '2';

 		$captcha_text[33]['question'] = 'In the number 84657, what is the 5th digit?';
 		$captcha_text[33]['answer']	  = '7';

 		$captcha_text[34]['question'] = 'In the number 63829, what is the 1st digit?';
 		$captcha_text[34]['answer']	  = '6';

 		$captcha_text[35]['question'] = 'In the number 29283, what is the 2nd digit?';
 		$captcha_text[35]['answer']	  = '9';

 		$captcha_text[36]['question'] = 'In the number 20384, what is the 3rd digit?';
 		$captcha_text[36]['answer']	  = '3';

 		$captcha_text[37]['question'] = 'In the number 77283, what is the 4th digit?';
 		$captcha_text[37]['answer']	  = '8';

 		$captcha_text[38]['question'] = 'In the number 94847, what is the 5th digit?';
 		$captcha_text[38]['answer']	  = '7';

 		$captcha_text[39]['question'] = 'In the number 24161, what is the 2nd digit?';
 		$captcha_text[39]['answer']	  = '4';

 		$captcha_text[40]['question'] = 'If tomorrow is Monday what day is today?';
 		$captcha_text[40]['answer']	  = 'sunday';

 		$captcha_text[41]['question'] = 'If tomorrow is Tuesday what day is today?';
 		$captcha_text[41]['answer']	  = 'monday';

 		$captcha_text[42]['question'] = 'If tomorrow is Wednesday what day is today?';
 		$captcha_text[42]['answer']	  = 'tuesday';

 		$captcha_text[43]['question'] = 'If tomorrow is Thursday what day is today?';
 		$captcha_text[43]['answer']	  = 'wednesday';

 		$captcha_text[44]['question'] = 'If tomorrow is Friday what day is today?';
 		$captcha_text[44]['answer']	  = 'thursday';

 		$captcha_text[45]['question'] = 'If tomorrow is Saturday what day is today?';
 		$captcha_text[45]['answer']	  = 'friday';

 		$captcha_text[46]['question'] = 'If tomorrow is Sunday what day is today?';
 		$captcha_text[46]['answer']	  = 'saturday';

 		$captcha_text[47]['question'] = 'If yesterday was Monday what day is today?';
 		$captcha_text[47]['answer']	  = 'tuesday';

 		$captcha_text[48]['question'] = 'If yesterday was Friday what day is today?';
 		$captcha_text[48]['answer']	  = 'saturday';

 		$captcha_text[49]['question'] = 'If yesterday was Sunday what day is today?';
 		$captcha_text[49]['answer']	  = 'monday';

 		$captcha_text[50]['question'] = 'The color of a red rose is?';
 		$captcha_text[50]['answer']	  = 'red';

 		$captcha_text[51]['question'] = 'The color of a black coat is?';
 		$captcha_text[51]['answer']	  = 'black';

 		$captcha_text[52]['question'] = 'The color of a green leaf is?';
 		$captcha_text[52]['answer']	  = 'green';

 		$captcha_text[53]['question'] = 'The color of a white rabbit is?';
 		$captcha_text[53]['answer']	  = 'white';

 		$captcha_text[54]['question'] = 'The color of a yellow bird is?';
 		$captcha_text[54]['answer']	  = 'yellow';

 		$captcha_text[55]['question'] = 'If the car is red, what color is it?';
 		$captcha_text[55]['answer']	  = 'red';

 		$captcha_text[56]['question'] = 'If the bird is blue, what color is it?';
 		$captcha_text[56]['answer']	  = 'blue';

 		$captcha_text[57]['question'] = 'If the cat is black, what color is it?';
 		$captcha_text[57]['answer']	  = 'black';

 		$captcha_text[58]['question'] = 'If the wall is white, what color is it?';
 		$captcha_text[58]['answer']	  = 'white';

 		$captcha_text[59]['question'] = 'If the coat is green, what color is it?';
 		$captcha_text[59]['answer']	  = 'green';

 		$captcha_text[60]['question'] = '2, 4, 8, 10 : which of these is the largest?';
 		$captcha_text[60]['answer']	  = '10';

 		$captcha_text[61]['question'] = '2, 14, 8, 5 : which of these is the largest?';
 		$captcha_text[61]['answer']	  = '14';

 		$captcha_text[62]['question'] = '12, 4, 8, 1 : which of these is the largest?';
 		$captcha_text[62]['answer']	  = '12';

 		$captcha_text[63]['question'] = '2, 40, 8, 1 : which of these is the largest?';
 		$captcha_text[63]['answer']	  = '40';

 		$captcha_text[64]['question'] = '3, 4, 7, 10 : which of these is the largest?';
 		$captcha_text[64]['answer']	  = '10';

 		$captcha_text[65]['question'] = '2, 1, 8, 3 : which of these is the largest?';
 		$captcha_text[65]['answer']	  = '8';

 		$captcha_text[66]['question'] = '2, 4, 18, 1 : which of these is the largest?';
 		$captcha_text[66]['answer']	  = '18';

 		$captcha_text[67]['question'] = '2, 24, 8, 1 : which of these is the largest?';
 		$captcha_text[67]['answer']	  = '24';

 		$captcha_text[68]['question'] = '22, 4, 8, 0 : which of these is the largest?';
 		$captcha_text[68]['answer']	  = '22';

 		$captcha_text[69]['question'] = '2, 4, 80, 1 : which of these is the largest?';
 		$captcha_text[69]['answer']	  = '80';

 		$captcha_text[70]['question'] = '5, 6, 7, 8 : the 2nd number is?';
 		$captcha_text[70]['answer']	  = '6';

 		$captcha_text[71]['question'] = '5, 6, 7, 8 : the 3rd number is?';
 		$captcha_text[71]['answer']	  = '7';

 		$captcha_text[72]['question'] = '5, 6, 7, 8 : the 4th number is?';
 		$captcha_text[72]['answer']	  = '8';

 		$captcha_text[73]['question'] = '5, 6, 7, 8 : the 1st number is?';
 		$captcha_text[73]['answer']	  = '5';

 		$captcha_text[74]['question'] = '4, 5, 6, 7 : the 1st number is?';
 		$captcha_text[74]['answer']	  = '4';

 		$captcha_text[75]['question'] = '4, 5, 6, 7 : the 2nd number is?';
 		$captcha_text[75]['answer']	  = '5';

 		$captcha_text[76]['question'] = '4, 5, 6, 7 : the 3rd number is?';
 		$captcha_text[76]['answer']	  = '6';

 		$captcha_text[77]['question'] = '4, 5, 6, 7 : the 4th number is?';
 		$captcha_text[77]['answer']	  = '7';

 		$captcha_text[78]['question'] = '7, 8, 9, 10 : the 2nd number is?';
 		$captcha_text[78]['answer']	  = '8';

 		$captcha_text[79]['question'] = '7, 8, 9, 10 : the 3rd number is?';
 		$captcha_text[79]['answer']	  = '9';

 		$captcha_text[80]['question'] = 'What is "one hundred" as a number?';
 		$captcha_text[80]['answer']	  = '100';

 		$captcha_text[81]['question'] = 'What is "two hundred" as a number?';
 		$captcha_text[81]['answer']	  = '200';

 		$captcha_text[82]['question'] = 'What is "three hundred" as a number?';
 		$captcha_text[82]['answer']	  = '300';

 		$captcha_text[83]['question'] = 'What is "four hundred" as a number?';
 		$captcha_text[83]['answer']	  = '400';

 		$captcha_text[84]['question'] = 'What is "five hundred" as a number?';
 		$captcha_text[84]['answer']	  = '500';

 		$captcha_text[85]['question'] = 'What is "six hundred" as a number?';
 		$captcha_text[85]['answer']	  = '600';

 		$captcha_text[86]['question'] = 'What is "seven hundred" as a number?';
 		$captcha_text[86]['answer']	  = '600';

 		$captcha_text[87]['question'] = 'What is "eight hundred" as a number?';
 		$captcha_text[87]['answer']	  = '800';

 		$captcha_text[88]['question'] = 'What is "nine hundred" as a number?';
 		$captcha_text[88]['answer']	  = '900';

 		$captcha_text[89]['question'] = 'What is "one" as a number?';
 		$captcha_text[89]['answer']	  = '1';

 		$captcha_text[90]['question'] = 'What is "two" as a number?';
 		$captcha_text[90]['answer']	  = '2';

 		$captcha_text[91]['question'] = 'What is "three" as a number?';
 		$captcha_text[91]['answer']	  = '3';

 		$captcha_text[92]['question'] = 'What is "four" as a number?';
 		$captcha_text[92]['answer']	  = '4';

 		$captcha_text[93]['question'] = 'What is "five" as a number?';
 		$captcha_text[93]['answer']	  = '5';

 		$captcha_text[94]['question'] = 'What is "six" as a number?';
 		$captcha_text[94]['answer']	  = '6';

 		$captcha_text[95]['question'] = 'What is "seven" as a number?';
 		$captcha_text[95]['answer']	  = '7';

 		$captcha_text[96]['question'] = 'What is "eight" as a number?';
 		$captcha_text[96]['answer']	  = '8';

 		$captcha_text[97]['question'] = 'What is "nine" as a number?';
 		$captcha_text[97]['answer']	  = '9';

 		$captcha_text[98]['question'] = 'What is "ten" as a number?';
 		$captcha_text[98]['answer']	  = '10';

 		$captcha_text[99]['question'] = 'What is "eleven" as a number?';
 		$captcha_text[99]['answer']	  = '11';

 		$random_key = array_rand($captcha_text,1);
 		$result_captcha = $captcha_text[$random_key];

 		return $result_captcha;

 	}
 ?>