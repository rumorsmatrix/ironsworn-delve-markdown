<?php

$text = file_get_contents('themes.json');
$themes_json = json_decode($text, 1);

$text = file_get_contents('domains.json');
$domains_json = json_decode($text, 1);

foreach ($themes_json['Themes'] as $theme) {
	foreach ($domains_json['Domains'] as $domain) {

		$html = "## {$theme['Name']} {$domain['Name']}\n";
		$html .= "**{$theme['Summary']}** {$theme['Description']}\n\n";
		$html .= "**{$domain['Summary']}** {$domain['Description']}\n\n";

		$html .= "### Features\n";
	    $html .= "| d100  | Feature  |\n";
	    $html .= "|-------|----------|\n";
		$html .= doRows(array_merge($theme['Features'], $domain['Features']));
	    $html .= "^"
			. str_replace(' ', '', $theme['Name'])
			. str_replace(' ', '', $domain['Name'])
			. "Features\n\n";

		$html .= "### Dangers\n";
	    $html .= "| d100  | Danger  |\n";
	    $html .= "|-------|----------|\n";
		$html .= doRows(array_merge($theme['Dangers'], $domain['Dangers']));
		$html .= "| 46-57 | You encounter a hostile denizen.\n";
		$html .= "| 58-68 | You face an environmental or architectural hazard.\n";
		$html .= "| 69-76 | A discoveryundermines or complicates your quest.\n";
		$html .= "| 77-79 | You confront a harrowing situation or sensation.\n";
		$html .= "| 80-82 | You face the consequences of an earlier choice or approach.\n";
		$html .= "| 83-85 | Your way is blocked or trapped.\n";
		$html .= "| 86-88 | A resource is diminished, broken, or lost.\n";
		$html .= "| 89-91 | You face a perplexing mystery or tough choice.\n";
		$html .= "| 92-94 | You lose your way or are delayed.\n";
		$html .= "| 95-00 | Roll twice more on this table. Both results occur. If they are the same result, make it worse.\n";
	    $html .= "^"
			. str_replace(' ', '', $theme['Name'])
			. str_replace(' ', '', $domain['Name'])
			. "Dangers\n\n";


		file_put_contents($theme['Name'] . ' ' . $domain['Name'] . '.md', $html);
		echo $html;
	}
}



function doRows($arr) {
    $start_chance = 1;
	$s = '';

    foreach ($arr as $row) {
        $s .= "| "
	    	. (($start_chance != $row['Chance']) ? "{$start_chance}-{$row['Chance']}" : "{$start_chance}")
       		. " | {$row['Description']}  |\n";
		$start_chance = $row['Chance'] + 1;
   	}

	return $s;
}
