<?php
function checkServer($domains = array(), $url)
{
    foreach ($domains as $domain) {
        if (strpos($url, $domain) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
function videoType2($url)
{
    if (checkServer(array("youtube.com", "youtu.be"), $url)) {
        $result = "youtube";
    } elseif (checkServer(array("vimeo.com"), $url)) {
        $result = "vimeo";
    } else {
        $result = false;
    }
    return $result;
}
function videoUrl($url)
{
    $type = videoType2($url);
    if ($type == "youtube") {
        $youtubeLink = $url;
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeLink, $match);
        $youtube_id = $match[1];
        $link = "//www.youtube.com/embed/" . $youtube_id;
    } elseif ($type == "vimeo") {
        $vimeoLink = $url;
        preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $vimeoLink, $match);
        $vimeo_id = $match[5];
        $link = "//player.vimeo.com/video/" . $vimeo_id;
    } else {
        $link = false;
    }
    return $link;
}
