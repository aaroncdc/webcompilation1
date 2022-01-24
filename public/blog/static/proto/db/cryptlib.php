<?php

class CryptLib
{
	function strord($str)
	{
		$result = 0;
		foreach(str_split($str) as $c)
		{
			$result += ~(ord($c));
		}
		return $result;
	}

	function mix($p, $n)
	{
		mt_srand($this->strord($p)+$this->strord($n));
		$result = "";
		$len = 0;
		$crc = 0;
		if(strlen($p)>strlen($n))
			$len = strlen($p);
		else
			$len = strlen($n);
		
		for($i = 0; $i < $len; $i++)
		{
			if($i >= strlen($n) || $i >= strlen($p))
			{
				$result .= (($i >= strlen($p))?$n[$i]:$p[$i]);
				$crc += ord(($i >= strlen($p))?$n[$i]:$p[$i])<<mt_rand(0,4);
			}else{
				$result .= (($i%2===0)?$p[$i]:$n[$i]);
				$crc += ord(($i%2===0)?$p[$i]:$n[$i])<<mt_rand(0,4);
			}
		}
		return array(hash("sha512",$result), $crc);
	}

	function randchars($many, $seed, $nosymbols = false)
	{
		$letters = "./01234abcdefghijklmnopqrstuvwxyz/.56789ABCDEFGHIJKLMNOPQRSTUVWXYZ./";
		mt_srand(~($many<<2)+$seed);
		$result = "";
		for($i = 0; $i < $many; $i++)
		{
			if(!$nosymbols)
				$result .= chr(mt_rand(32,126));
			else
				$result .= str_split($letters)[mt_rand(0,strlen($letters)-1)];
		}
		return $result;
	}

	function hidepassword($PASSWORD, $HASH)
	{
		$md1 = hash("sha512", strrev($PASSWORD));
		$md2 = hash("sha512", strrev($HASH));
		$hash1 = hash("sha512",$this->randchars(255, $this->strord($md1)-1));
		$hash2 = hash("sha512",$this->randchars(255, $this->strord($md2)-1));
		$mixedhash = $this->mix($hash2, $hash1);
		$mixedhash[0] = hash("sha512", $mixedhash[0]);
		$password1 = password_hash($md1.$md2, PASSWORD_BCRYPT, ['salt'=>$mixedhash[0].strrev($mixedhash[0])]);
		$password2 = password_hash($md2.$md1, PASSWORD_BCRYPT, ['salt'=>strrev($mixedhash[0]).$mixedhash[0]]);
		
		$randc1 = $this->randchars(strlen($password1), $this->strord($password2));
		$randc2 = $this->randchars(strlen($password2), $this->strord($password1));
		
		$password1 = $this->mix(str_replace("$2y$", "", $password1), $randc1)[0];
		$password2 = $this->mix(str_replace("$2y$", "", $password2), $randc2)[0];
		
		if($this->strord($password1 . $password2)%2 === 0)
			$final = $this->randchars($mixedhash[1]%2==0?8:7, $mixedhash[1]>>1, true) . $password1 . $this->randchars($mixedhash[1]%3==0?5:6,
				$mixedhash[1], true) . $password2 . $this->randchars($mixedhash[1]%2==0?4:5, $mixedhash[1]<<1, true);
		else
			$final = $password2 . $this->randchars($mixedhash[1]%2==0?6:5, $mixedhash[1]>>1, true) . $this->randchars($mixedhash[1]%2==0?8:7,
				$mixedhash[1]<<1, true) . $password1 . $this->randchars($mixedhash[1]%3==0?5:4, $mixedhash[1], true);
			
		return str_replace("$","",$final);
	}
}

?>
