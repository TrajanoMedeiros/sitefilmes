<?php
// Ler o conteúdo do arquivo .m3u
$file_content = file_get_contents('teste2.m3u');

// Quebra o conteúdo em linhas
$lines = explode("\n", $file_content);

$channels = []; // Array para armazenar os canais e seus ícones

foreach ($lines as $line) {
    // Verifica se a linha contém o "tvg-logo" (ícone do canal)
    if (strpos($line, 'tvg-logo=') !== false) {
        // Extraí o logo e a URL do canal
        preg_match('/tvg-logo="([^"]+)"/', $line, $matches_logo);
        preg_match('/,([^,]+)/', $line, $matches_channel_name);
        $channel_name = isset($matches_channel_name[1]) ? $matches_channel_name[1] : "Desconhecido";
        $logo_url = isset($matches_logo[1]) ? $matches_logo[1] : null;

        // Verifica se existe uma URL válida para o logo
        if ($logo_url) {
            $channels[] = [
                'name' => $channel_name,
                'logo' => $logo_url
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script type="text/javascript" src="script.js"></script>
    <title>Lista de Canais</title>

<body>
    <h1>Canais de TV</h1>
    <div class="channel-container">
        <?php foreach ($channels as $channel): ?>
            <div class="channel">
                <!-- Exibe o ícone do canal -->
                <a href="#" onclick="playStream('<?php echo $channel['name']; ?>')">
                    <img src="<?php echo $channel['logo']; ?>" alt="<?php echo $channel['name']; ?>" />
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="player-container">
        <h2 id="player-title"></h2>
        <video id="player" controls>
            <source id="player-source" src="" type="application/x-mpegURL">
            Seu navegador não suporta o player de vídeo.
        </video>
    </div>

    <script>
        // Função para exibir o player com a URL do canal
        function playStream(channelName) {
            // Mapeando o nome do canal para o link de stream
            const streams = {
                "EURONEWS": "https://euronews-euronews-portugues-1-br.samsung.wurl.tv/playlist.m3u8",
                "Retrô Cartoon": "https://stmv1.srvif.com/retrotv/retrotv/playlist.m3u8",
                "RT en español": "https://rt-esp.rttv.com/live/rtesp/playlist.m3u8",
                "RT Documentary": "https://rt-doc.rttv.com/live/rt-doc/playlist.m3u8",
                "RT UK": "https://rt-uk.rttv.com/live/rt-uk/playlist.m3u8",
                "RT France": "https://rt-france.rttv.com/live/rt-france/playlist.m3u8",
                "RT Arabic": "https://rt-arabic.rttv.com/live/rt-arabic/playlist.m3u8",
                "RT America": "https://rt-america.rttv.com/live/rt-america/playlist.m3u8",
                "RT News": "https://rt-news.rttv.com/live/rt-news/playlist.m3u8",
                "RT Español": "https://rt-esp.rttv.com/live/rtesp/playlist.m3u8",
                "A&E HD":"http://135.148.169.68:80/ottplayerchannel/JFYQWKNbCUe5/665",
            };

            // Verifica se o nome do canal existe no mapeamento
            if (streams[channelName]) {
                // Atualiza o título e a fonte do vídeo
                document.getElementById('player-title').innerText = channelName;
                document.getElementById('player-source').src = streams[channelName];

                // Exibe o player
                document.getElementById('player-container').style.display = 'block';
                document.getElementById('player').load(); // Carrega o stream
            } else {
                alert("Canal não encontrado!");
            }
        }
    </script>
</body>
</html>
