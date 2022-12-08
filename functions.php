<?php

function getLastUrl($url, $try = 1)
{
	if ($try >= 5)
		return "";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // set browser info to avoid old browser warnings
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // allow url redirects
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // get the return value of curl execution as a string

	$html = curl_exec($ch);
	// store last redirected url in a variable before closing the curl session
	$lastUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	curl_close($ch);

	if (strpos($html, '<link data-react-helmet="true" rel="canonical" href="https://www.tiktok.com/@') !== false) {
		preg_match('/<link data-react-helmet=\"true\" rel=\"canonical\" href=\"([^\"]*)\"\/>/iU', $html, $matches);
		return $matches[1];
	}

	return $lastUrl;
}

echo getLastUrl('https://v.douyin.com/hjAAc2w/');