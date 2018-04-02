
$words = ['weten', 'noot', 'zetten', 'zes', 'jurk', 'plukken', 'gezelschap', 'geven', 'ster', 'mooi', 'tijd', 'uit', 'zoeken', 'winter', 'leuk'];

$groups = [3,4,5,6,7,3,4,5,6,7,3,4,5,6,7];

for ($i=1; $i < 16; $i++) { 
	$word = $words[$i - 1];
	$groupID = $groups[$i - 1];
	(new pDataModel('survey_words'))->complexQuery("INSERT INTO survey_words(id, language, word, audiofile, internID, survey_version, survey_id, survey_word_group, sorter) VALUES(NULL, '1', '', '".$word.".ogg', '".$word."', '3', '2', '".$groupID."', '".$i."');");
	(new pDataModel('survey_words'))->complexQuery("INSERT INTO survey_words(id, language, word, audiofile, internID, survey_version, survey_id, survey_word_group, sorter) VALUES(NULL, '1', '".$word."', '', '".$word."', '1', '2', '".$groupID."', '".$i."');");
}

$words = ['dag', 'schip', 'appel', 'been', 'aardappel', 'ploeg', 'rijk', 'rijk', 'rijk', 'moeder', 'nee', 'nee', 'bang', 'bang', 'bang', 'tand', 'nacht','grijpen', 'knie', 'fiets'];

$translations = ['dag', 'skepp', 'äpple', 'ben', 'potatis', 'plog', 'rik', 'rika', 'rikt', 'mor', 'moder', 'mamma', 'nej', 'nä', 'rädd', 'rätt', 'rädda', 'tand', 'natt', 'gripa', 'knä', 'cykel'];

foreach($words as $i => $word){
	(new pDataModel)->complexQuery('INSERT INTO survey_correct_translations (id, survey_id, language, internID, translation) VALUES (NULL, "2", "2", "'.$word.'", "'.$translations[$i].'");');}