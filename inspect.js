javascript:(function() {
    // Modal oluşturma
    let modal = document.createElement('div');
    modal.style.cssText = `
        display: none;
        position: fixed;
        z-index: 999999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        cursor: zoom-in;
    `;
    
    let modalImg = document.createElement('img');
    modalImg.style.cssText = `
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    `;

    // Butonlar için container
    let buttonContainer = document.createElement('div');
    buttonContainer.style.cssText = `
        position: fixed;
        top: 20px;
        right: 100px;
        z-index: 1000000;
        display: flex;
        gap: 10px;
    `;

    // Yeni sekmede aç butonu
    let openBtn = document.createElement('button');
    openBtn.innerHTML = '↗️ Görseli Aç';
    openBtn.style.cssText = `
        padding: 8px 15px;
        background: #2196F3;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
    `;
    openBtn.onmouseover = () => openBtn.style.background = '#1976D2';
    openBtn.onmouseout = () => openBtn.style.background = '#2196F3';
    
    let closeBtn = document.createElement('span');
    closeBtn.innerHTML = '&times;';
    closeBtn.style.cssText = `
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1000000;
    `;

    buttonContainer.appendChild(openBtn);
    modal.appendChild(buttonContainer);
    modal.appendChild(closeBtn);
    modal.appendChild(modalImg);
    document.body.appendChild(modal);
    
    let currentScale = 1;
    const scaleStep = 0.1;

    // Yeni sekmede görsel açma fonksiyonu
    function openImageInNewTab(url) {
        window.open(url, '_blank');
    }

    // Orijinal görsel URL'sini bulma fonksiyonu
    function findOriginalImage(element) {
        let parent = element;
        while (parent) {
            const links = parent.getElementsByTagName('a');
            for (let link of links) {
                if (link.href) {
                    const match = link.href.match(/imgurl=([^&]+)/);
                    if (match && match[1]) {
                        return decodeURIComponent(match[1]);
                    }
                }
            }
            parent = parent.parentElement;
        }

        const allLinks = document.getElementsByTagName('a');
        for (let link of allLinks) {
            if (link.href) {
                const match = link.href.match(/imgurl=([^&]+)/);
                if (match && match[1]) {
                    return decodeURIComponent(match[1]);
                }
            }
        }

        return element.src;
    }

    // Tıklama olayını dinle
    document.addEventListener('click', function(e) {
        let imgElement = e.target.closest('img');
        
        if (imgElement) {
            e.preventDefault();
            e.stopPropagation();
            
            const originalUrl = findOriginalImage(imgElement);
            
            if (originalUrl) {
                console.log('Yüklenen görsel:', originalUrl);
                modal.style.display = 'block';
                modalImg.src = originalUrl;
                currentScale = 1;
                modalImg.style.transform = 'translate(-50%, -50%) scale(1)';

                // Buton olayını güncelle
                openBtn.onclick = () => openImageInNewTab(originalUrl);
            }
        }
    }, true);
    
    // Zoom işlemleri
    modal.addEventListener('wheel', function(e) {
        e.preventDefault();
        if (e.deltaY < 0) {
            currentScale += scaleStep;
        } else {
            currentScale = Math.max(0.1, currentScale - scaleStep);
        }
        modalImg.style.transform = `translate(-50%, -50%) scale(${currentScale})`;
    }, { passive: false });
    
    // Modal kapatma
    closeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        modal.style.display = 'none';
    });
    
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // ESC tuşu ile kapatma
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modal.style.display = 'none';
        }
    });

    console.log('Script aktif - Görsellere tıklayarak modalda açabilirsiniz');
})();