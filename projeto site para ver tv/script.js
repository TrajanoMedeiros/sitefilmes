// script.js

function playStream(url) {
    var player = document.getElementById('video-player');
    player.src = url;
    player.play();
}
