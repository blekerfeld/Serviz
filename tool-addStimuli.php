
$words = ['weten', 'noot', 'zetten', 'zes', 'jurk', 'plukken', 'gezelschap', 'geven', 'ster', 'mooi', 'tijd', 'uit', 'zoeken', 'winter', 'leuk'];

$groups = [3,4,5,6,7,3,4,5,6,7,3,4,5,6,7];

for ($i=1; $i < 16; $i++) { 
	$word = $words[$i - 1];
	$groupID = $groups[$i - 1];
	(new pDataModel('survey_words'))->complexQuery("INSERT INTO survey_words(id, language, word, audiofile, internID, survey_version, survey_id, survey_word_group, sorter) VALUES(NULL, '1', '', '".$word.".ogg', '".$word."', '3', '2', '".$groupID."', '".$i."');");
	(new pDataModel('survey_words'))->complexQuery("INSERT INTO survey_words(id, language, word, audiofile, internID, survey_version, survey_id, survey_word_group, sorter) VALUES(NULL, '1', '".$word."', '', '".$word."', '1', '2', '".$groupID."', '".$i."');");
}