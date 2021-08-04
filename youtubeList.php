<?php
// googole link
// https://developers.google.com/youtube/v3/docs/playlistItems/list
// $url = "https://www.googleapis.com/youtube/v3/search?key={your_key_here}&channelId={channel_id_here}&part=snippet,id&order=date&maxResults=20";
$url = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyDw5G25kLYYyJxm0OmgSRmGZZcvk8iwubM&channelId=UCzW4py36DRUN_izDpJQH9iw&part=id&order=date&maxResults=50";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
$json = curl_exec($ch);
if (!$json) {
    echo curl_error($ch);
}
curl_close($ch);
$data = json_decode($json);
$data = $data->items;
$data = array_column($data, "id");
$data = array_column($data, "videoId");
?>
<?php foreach ($data as  $item) : ?>
    <div class="col-md-4">
        <iframe width="100%" height="270" src="https://www.youtube.com/embed/<?= $item ?>" class="margin-video" frameborder="0" allowfullscreen></iframe>
    </div>
<?php endforeach; ?>
