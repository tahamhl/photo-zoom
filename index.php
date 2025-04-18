<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Görsel Arama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .search-container {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #1976D2;
        }
        .instructions {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            margin-top: 20px;
        }
        .code-container {
            position: relative;
            margin-top: 20px;
        }
        #copyButton {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #4CAF50;
        }
        #copyButton:hover {
            background: #45a049;
        }
        pre {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            position: relative;
        }
        .success-message {
            display: none;
            color: #4CAF50;
            margin-top: 10px;
        }
        .bookmarklet-container {
            margin-top: 20px;
            text-align: center;
        }
        .bookmarklet {
            display: inline-block;
            padding: 10px 20px;
            background: #ff4081;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 0;
            font-weight: bold;
        }
        .bookmarklet:hover {
            background: #f50057;
        }
        .or-divider {
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="search-container">
        <h2>Google Görsel Arama</h2>
        <form id="searchForm">
            <input type="text" id="searchQuery" placeholder="Aranacak kelimeyi girin..." required>
            <button type="submit">Ara</button>
        </form>
    </div>

    <div class="instructions">
        <h3>Kolayy Kullanım (Önerilen)</h3>
        <ol>
            <li>Aşağıdaki "Modal Görüntüleyici" butonunu tarayıcınızın yer imlerine sürükleyin.</li>
            <li>Google Görseller'de arama yapın.</li>
            <li>Yer imlerinden "Modal Görüntüleyici"ye tıklayın.</li>
            <li>Artık görsellere tıkladığınızda modal pencerede açılacak!</li>
        </ol>

        <div class="bookmarklet-container">
            <a href="" id="bookmarklet" class="bookmarklet" title="Bu butonu tarayıcınızın yer imlerine sürükleyin">🖼️ Modal Görüntüleyici</a>
        </div>

        <div class="or-divider">- VEYA -</div>

        <h3>Manuel Kullanım</h3>
        <ol>
            <li>Yukarıdaki kutuya aranacak kelimeyi yazın ve "Ara" butonuna tıklayın.</li>
            <li>Google Görseller yeni sekmede açılacak.</li>
            <li>Aşağıdaki "Kodu Kopyala" butonuna tıklayın.</li>
            <li>Google Görseller sekmesinde F12 tuşuna basarak konsolu açın.</li>
            <li>Kopyaladığınız kodu konsola yapıştırın ve Enter'a basın.</li>
        </ol>

        <div class="code-container">
            <button id="copyButton">Kodu Kopyala</button>
            <pre id="inspectCode"></pre>
            <div id="successMessage" class="success-message">Kod başarıyla kopyalandı!</div>
        </div>
    </div>

    <script>
        // inspect.js içeriğini bir değişkende tutuyoruz
        const inspectCode = 'javascript:(function() {' +
        'let modal = document.createElement("div");' +
        'modal.style.cssText = "display: none; position: fixed; z-index: 999999; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.9); cursor: zoom-in;";' +
        
        'let modalImg = document.createElement("img");' +
        'modalImg.style.cssText = "margin: auto; display: block; max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);";' +
        
        'let buttonContainer = document.createElement("div");' +
        'buttonContainer.style.cssText = "position: fixed; top: 20px; right: 100px; z-index: 1000000; display: flex; gap: 10px;";' +
        
        'let openBtn = document.createElement("button");' +
        'openBtn.innerHTML = "↗️ Görseli Aç";' +
        'openBtn.style.cssText = "padding: 8px 15px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;";' +
        
        'let helpBtn = document.createElement("button");' +
        'helpBtn.innerHTML = "❔ Yardım";' +
        'helpBtn.style.cssText = "padding: 8px 15px; background: #9c27b0; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;";' +
        
        'let closeBtn = document.createElement("span");' +
        'closeBtn.innerHTML = "&times;";' +
        'closeBtn.style.cssText = "position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer;";' +
        
        'let infoPanel = document.createElement("div");' +
        'infoPanel.style.cssText = "display: none; position: fixed; bottom: 20px; left: 20px; background: rgba(0, 0, 0, 0.9); color: white; padding: 15px; border-radius: 8px; z-index: 1000001; font-family: Arial, sans-serif; max-width: 300px;";' +
        'document.body.appendChild(infoPanel);' +

        'let helpPanel = document.createElement("div");' +
        'helpPanel.style.cssText = "display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1000001; cursor: pointer;";' +

        'let helpContent = document.createElement("div");' +
        'helpContent.style.cssText = "position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0, 0, 0, 0.9); color: white; padding: 20px; border-radius: 8px; font-family: Arial, sans-serif; max-width: 400px; cursor: default;";' +
        
        'helpContent.innerHTML = "<h3 style=\'margin-top: 0;\'>Klavye Kısayolları</h3>" +' +
            '"<ul style=\'list-style-type: none; padding: 0;\'>" +' +
            '"<li>→ : Sonraki görsel</li>" +' +
            '"<li>← : Önceki görsel</li>" +' +
            '"<li>Tab : Görseli yeni sekmede aç</li>" +' +
            '"<li>S : Görseli kaydet</li>" +' +
            '"<li>R : Görseli saat yönünde döndür</li>" +' +
            '"<li>Shift + R : Görseli saatin tersi yönünde döndür</li>" +' +
            '"<li>i : Görsel bilgilerini göster</li>" +' +
            '"<li>? : Bu yardım menüsü</li>" +' +
            '"<li>ESC : Modal/Menü kapat</li>" +' +
            '"</ul>";' +

        'helpPanel.appendChild(helpContent);' +
        'document.body.appendChild(helpPanel);' +

        'buttonContainer.appendChild(helpBtn);' +
        'buttonContainer.appendChild(openBtn);' +
        'modal.appendChild(buttonContainer);' +
        'modal.appendChild(closeBtn);' +
        'modal.appendChild(modalImg);' +
        'document.body.appendChild(modal);' +
        
        'let viewHistory = [];' +
        'let currentHistoryIndex = -1;' +
        'let currentScale = 1;' +
        'let currentRotation = 0;' +
        'const scaleStep = 0.1;' +
        
        'function findOriginalImage(element) {' +
            'if (element.src.includes("data:image")) {' +
                'const parent = element.closest("div");' +
                'if (parent) {' +
                    'const links = parent.getElementsByTagName("a");' +
                    'for (let link of links) {' +
                        'if (link.href && link.href.includes("imgurl=")) {' +
                            'const match = link.href.match(/imgurl=([^&]+)/);' +
                            'if (match && match[1]) {' +
                                'return decodeURIComponent(match[1]);' +
                            '}' +
                        '}' +
                    '}' +
                '}' +
            '}' +
            
            'let parent = element;' +
            'while (parent) {' +
                'const links = parent.getElementsByTagName("a");' +
                'for (let link of links) {' +
                    'if (link.href) {' +
                        'const match = link.href.match(/imgurl=([^&]+)/);' +
                        'if (match && match[1]) {' +
                            'return decodeURIComponent(match[1]);' +
                        '}' +
                    '}' +
                '}' +
                'parent = parent.parentElement;' +
            '}' +
            
            'if (element.src.includes("gstatic.com")) {' +
                'return element.src.replace(/w\d+-h\d+/, "w" + element.naturalWidth + "-h" + element.naturalHeight);' +
            '}' +
            
            'const originalSrc = element.getAttribute("data-src") || element.src;' +
            'if (originalSrc.includes("data:image")) {' +
                'const parent = element.closest("div");' +
                'if (parent) {' +
                    'const img = parent.querySelector("img[src*=\'gstatic.com\']");' +
                    'if (img) {' +
                        'return img.src.replace(/w\d+-h\d+/, "w" + img.naturalWidth + "-h" + img.naturalHeight);' +
                    '}' +
                '}' +
            '}' +
            'return originalSrc;' +
        '}' +
        
        'function showModal(originalUrl) {' +
            'modal.style.display = "block";' +
            'modalImg.src = originalUrl;' +
            'currentScale = 1;' +
            'currentRotation = 0;' +
            'modalImg.style.transform = "translate(-50%, -50%) scale(1) rotate(0deg)";' +
            'openBtn.onclick = function() { window.open(originalUrl, "_blank"); };' +
            'updateImageInfo();' +
            'helpVisible = false;' +
            'infoVisible = false;' +
            'helpPanel.style.display = "none";' +
            'infoPanel.style.display = "none";' +
        '}' +
        
        'function updateImageInfo() {' +
            'const img = new Image();' +
            'img.onload = function() {' +
                'infoPanel.innerHTML = "<h4 style=\'margin-top: 0;\'>Görsel Bilgileri</h4>" +' +
                    '"<ul style=\'list-style-type: none; padding: 0; margin: 0;\'>" +' +
                    '"<li>Boyut: " + this.width + " x " + this.height + "px</li>" +' +
                    '"<li>Format: " + modalImg.src.split(".").pop().split("?")[0].toUpperCase() + "</li>" +' +
                    '"<li>Kaynak: " + new URL(modalImg.src).hostname + "</li>" +' +
                    '"</ul>";' +
            '};' +
            'img.src = modalImg.src;' +
        '}' +
        
        'function downloadImage(url) {' +
            'const fileName = url.split("/").pop().split("?")[0] || "gorsel.jpg";' +
            'fetch(url)' +
                '.then(response => response.blob())' +
                '.then(blob => {' +
                    'const link = document.createElement("a");' +
                    'link.href = window.URL.createObjectURL(blob);' +
                    'link.download = fileName;' +
                    'link.style.display = "none";' +
                    'document.body.appendChild(link);' +
                    'link.click();' +
                    'window.URL.revokeObjectURL(link.href);' +
                    'document.body.removeChild(link);' +
                '})' +
                '.catch(() => {' +
                    'const link = document.createElement("a");' +
                    'link.href = url;' +
                    'link.download = fileName;' +
                    'link.target = "_blank";' +
                    'link.click();' +
                '});' +
        '}' +
        
        'function rotateImage(direction) {' +
            'currentRotation += direction === "right" ? 90 : -90;' +
            'modalImg.style.transform = "translate(-50%, -50%) scale(" + currentScale + ") rotate(" + currentRotation + "deg)";' +
        '}' +
        
        'async function simulateImageClicks() {' +
            'console.log("Otomatik görsel yükleme başlatılıyor...");' +
            'await new Promise(function(resolve) { setTimeout(resolve, 2000); });' +
            
            'const imgElements = document.querySelectorAll("img");' +
            'console.log("Toplam " + imgElements.length + " görsel bulundu.");' +
            
            'let loadedCount = 0;' +
            'let processedCount = 0;' +
            
            'for (const img of imgElements) {' +
                'if (loadedCount >= 20) break;' +
                
                'const rect = img.getBoundingClientRect();' +
                'if (rect.width > 50 && rect.height > 50) {' +
                    'processedCount++;' +
                    'await new Promise(resolve => {' +
                        'if (img.complete) resolve();' +
                        'else img.onload = resolve;' +
                    '});' +
                    'const originalUrl = findOriginalImage(img);' +
                    
                    'if (originalUrl && !viewHistory.includes(originalUrl)) {' +
                        'console.log("Yükleniyor (" + (loadedCount + 1) + "/20): " + originalUrl);' +
                        
                        'try {' +
                            'await new Promise(function(resolve, reject) {' +
                                'const tempImg = new Image();' +
                                'tempImg.onload = function() {' +
                                    'viewHistory.push(originalUrl);' +
                                    'loadedCount++;' +
                                    'console.log("✓ Başarıyla yüklendi (" + loadedCount + "/20)");' +
                                    'resolve();' +
                                '};' +
                                'tempImg.onerror = function() {' +
                                    'console.error("✗ Yükleme başarısız: " + originalUrl);' +
                                    'reject();' +
                                '};' +
                                'tempImg.src = originalUrl;' +
                            '});' +
                        '} catch (error) {' +
                            'console.error("Görsel yükleme hatası:", error);' +
                        '}' +
                    '} else {' +
                        'console.log("Görsel atlandı (tekrar veya geçersiz): " + originalUrl);' +
                    '}' +
                '}' +
            '}' +
            
            'console.log("Yükleme tamamlandı:\\n- Toplam işlenen: " + processedCount + "\\n- Başarıyla yüklenen: " + loadedCount + "\\n- Geçmiş listesi uzunluğu: " + viewHistory.length);' +
            
            'if (viewHistory.length > 0) {' +
                'currentHistoryIndex = 0;' +
                'console.log("Görsel listesi hazır. Sağ/sol ok tuşlarıyla gezebilirsiniz.");' +
            '} else {' +
                'console.warn("Hiç görsel yüklenemedi!");' +
            '}' +
        '}' +
        
        'modal.addEventListener("wheel", function(e) {' +
            'e.preventDefault();' +
            'if (e.deltaY < 0) {' +
                'currentScale += scaleStep;' +
            '} else {' +
                'currentScale = Math.max(0.1, currentScale - scaleStep);' +
            '}' +
            'modalImg.style.transform = "translate(-50%, -50%) scale(" + currentScale + ") rotate(" + currentRotation + "deg)";' +
        '}, { passive: false });' +
        
        'document.addEventListener("click", function(e) {' +
            'let imgElement = e.target.closest("img");' +
            'if (imgElement) {' +
                'e.preventDefault();' +
                'e.stopPropagation();' +
                'const originalUrl = findOriginalImage(imgElement);' +
                'if (originalUrl) {' +
                    'if (!viewHistory.includes(originalUrl)) {' +
                        'viewHistory.push(originalUrl);' +
                        'currentHistoryIndex = viewHistory.length - 1;' +
                    '} else {' +
                        'currentHistoryIndex = viewHistory.indexOf(originalUrl);' +
                    '}' +
                    'showModal(originalUrl);' +
                '}' +
            '}' +
        '}, true);' +

        'closeBtn.addEventListener("click", function() {' +
            'modal.style.display = "none";' +
            'infoPanel.style.display = "none";' +
        '});' +

        'modal.addEventListener("click", function(event) {' +
            'if (event.target === modal) {' +
                'modal.style.display = "none";' +
                'infoPanel.style.display = "none";' +
            '}' +
        '});' +

        'function navigateHistory(direction) {' +
            'if (viewHistory.length === 0) {' +
                'console.log("Gezilecek görsel yok!");' +
                'return;' +
            '}' +
            
            'if (direction === "next") {' +
                'currentHistoryIndex = (currentHistoryIndex + 1) % viewHistory.length;' +
            '} else {' +
                'currentHistoryIndex = (currentHistoryIndex - 1 + viewHistory.length) % viewHistory.length;' +
            '}' +
            
            'console.log("Görsel değiştiriliyor (" + (currentHistoryIndex + 1) + "/" + viewHistory.length + ")");' +
            'showModal(viewHistory[currentHistoryIndex]);' +
        '}' +
        
        'document.addEventListener("keydown", function(e) {' +
            'if (modal.style.display === "block") {' +
                'if (e.key === "Escape") {' +
                    'if (helpVisible) {' +
                        'toggleHelp();' +
                    '} else if (infoVisible) {' +
                        'infoPanel.style.display = "none";' +
                        'infoVisible = false;' +
                    '} else {' +
                        'modal.style.display = "none";' +
                    '}' +
                '} else if (e.key === "Tab") {' +
                    'e.preventDefault();' +
                    'window.open(modalImg.src, "_blank");' +
                '} else if (e.key === "ArrowRight") {' +
                    'e.preventDefault();' +
                    'navigateHistory("next");' +
                '} else if (e.key === "ArrowLeft") {' +
                    'e.preventDefault();' +
                    'navigateHistory("prev");' +
                '} else if (e.key.toLowerCase() === "s" && !e.ctrlKey && !e.metaKey) {' +
                    'e.preventDefault();' +
                    'downloadImage(modalImg.src);' +
                '} else if (e.key.toLowerCase() === "r") {' +
                    'e.preventDefault();' +
                    'rotateImage(e.shiftKey ? "left" : "right");' +
                '} else if (e.key === "i") {' +
                    'e.preventDefault();' +
                    'infoVisible = !infoVisible;' +
                    'infoPanel.style.display = infoVisible ? "block" : "none";' +
                    'if (infoVisible) updateImageInfo();' +
                '} else if (e.key === "?") {' +
                    'e.preventDefault();' +
                    'toggleHelp();' +
                '}' +
            '}' +
        '});' +
        
        'let helpVisible = false;' +
        'let infoVisible = false;' +

        'function toggleHelp() {' +
            'helpVisible = !helpVisible;' +
            'helpPanel.style.display = helpVisible ? "block" : "none";' +
        '}' +

        'helpBtn.onclick = toggleHelp;' +

        'helpPanel.addEventListener("click", function(e) {' +
            'if (e.target === helpPanel) {' +
                'toggleHelp();' +
            '}' +
        '});' +

        'helpContent.addEventListener("click", function(e) {' +
            'e.stopPropagation();' +
        '});' +

        'simulateImageClicks().catch(function(error) {' +
            'console.error("Otomatik yükleme hatası:", error);' +
        '});' +

        'console.log("Script aktif - Görsellere tıklayarak modalda açabilirsiniz");' +
        '})();';

        // Arama formu işlemi
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = document.getElementById('searchQuery').value;
            const googleImagesUrl = `https://www.google.com/search?q=${encodeURIComponent(query)}&tbm=isch`;
            window.open(googleImagesUrl, '_blank');
        });

        // Kodu pre elementine yerleştir
        document.getElementById('inspectCode').textContent = inspectCode;

        // Kopyalama butonu işlevi
        document.getElementById('copyButton').addEventListener('click', function() {
            navigator.clipboard.writeText(inspectCode).then(function() {
                const successMessage = document.getElementById('successMessage');
                successMessage.style.display = 'block';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 2000);
            });
        });

        // Bookmarklet için kodu hazırla
        document.getElementById('bookmarklet').href = 'javascript:' + encodeURIComponent(inspectCode.replace('javascript:', ''));
    </script>
</body>
</html> 