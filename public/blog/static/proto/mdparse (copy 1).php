<?php

	class MarkdownParser
	{
		/* BEGIN OF MONKEY CODE */
		private $regbold = "/\*\*([^\*].*[^\*])\*\*/";
		private $regbold2 = "/__([^_].*[^_])__/";
		private $regitalic = "/\*(.*)\*/";
		private $regitalic2 = "/_(.*)_/";
		private $strikethrough = "/~~(.*)~~/";
		
		private $link1 = "/\[(.*)\]\((.*)\)/";
		private $image1 = "/!\[(.*)\]\((.*)\)/";
		
		private $blockcode = "/```(.*)/";
		
		private $codem = 0;
		private $codelang = "";
		
		function Parse($line)
		{
			global $regbold;
			$matches;
			
			if(strcmp(trim($line), "") === 0)
				return "";
				
			$words = array_filter(explode(" ", trim($line)));
			
			if($words[0][0]==='`' && preg_match($this->blockcode, $line, $matches))
			{
				if(count($matches) > 1)
				{
					$this->codelang = $matches[1];
					$result = "<pre>\n";
				}
				if($this->codem)
				{
					$this->codem = 0;
					$result = "</pre>\n";
					
				}
				$this->codem = 1;
				return $result;
				
			}
			if($this->codem === 1)
			{
				return $line;
			}
			if($words[0][0] == '#' && count($words) > 1)
			{
				$hlevel = 0;
				$carr = str_split($words[0]);
				foreach($carr as $c)
				{
					if($c == '#')
						$hlevel++;
					else
						break;
				}
				$result = "<h".$hlevel.">". trim(implode(' ', array_splice($words, 1))) . "</h".$hlevel.">";
				return $result;
			}
			if(trim($line) === "======" || trim($line) === "------")
			{
				$result = "<hr>";
				return $result;
			}
			
			$result = preg_replace($this->regbold, "<strong>$1</strong>", $line);
			$result = preg_replace($this->regbold2, "<strong>$1</strong>", $result);
			$result = preg_replace($this->regitalic, "<em>$1</em>", $result);
			$result = preg_replace($this->regitalic2, "<em>$1</em>", $result);
			$result = preg_replace($this->strikethrough, "<strike>$1</strike>", $result);
			
			$exec = 0;
			while(preg_match($this->image1, $result, $matches) && $exec < 99)
			{
				$result = str_replace($matches[0], '<img src="'.$matches[2].'" alt="'.$matches[1].'"></img>', $result);
				$exec++;
			}
			$exec = 0;
			while(preg_match($this->link1, $result, $matches) && $exec < 99)
			{
				$result = str_replace($matches[0], '<a href="'.$matches[2].'">'.$matches[1].'</a>', $result);
				$exec++;
			}

			if(strcmp(trim($result), "") !== 0)
				$result = "<p>" . trim($result) . "</p>\r\n";
			return $result;
		}
		
		/* END OF MONKEY CODE */
	}

	$mdparser = new MarkdownParser();
	$file = fopen("test.md", "r");
	if($file)
	{
		while(($line = fgets($file)) != false)
		{
			$rline = $mdparser->Parse($line);
			echo($rline);
		}
		fclose($file);
	}else{
		die("Whoops!");
	}
?>
