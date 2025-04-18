# Photo-Zoom 🔍

> Görselleri daha detaylı incelemek için tarayıcı eklentisi.
>
> A browser extension for detailed image inspection.

## 🇹🇷 Türkçe

### 📝 Proje Hakkında

**Photo-Zoom**, web sayfalarındaki görselleri tek tıklamayla tam boyutta görüntüleyip yakınlaştırma imkanı sunan bir JavaScript bookmarklet'tir. Google Görseller gibi sitelerde arama yaparken veya herhangi bir web sitesinde gezinirken görselleri kolayca incelemenizi sağlar.

### ✨ Özellikler

- Herhangi bir görsele tıklayarak orijinal boyutunda görüntüleme
- Fare tekerleği ile kolay yakınlaştırma ve uzaklaştırma
- Görseli yeni sekmede açma seçeneği
- Klavye kısayolu ile kolay kapatma (ESC tuşu)
- Hafif ve kurulum gerektirmeyen yapı

### 🚀 Kurulum

1. Aşağıdaki kodu kopyalayın:
   ```javascript
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
   ```
2. Tarayıcınızda yeni bir yer imi (bookmark) oluşturun
3. Yer iminin URL kısmına kopyaladığınız kodu yapıştırın
4. İsim kısmına "Photo-Zoom" veya istediğiniz bir isim yazın
5. Kaydedin

### 🔧 Kullanım

1. Görselleri incelemek istediğiniz bir web sayfasına gidin
2. Yer imi çubuğundan "Photo-Zoom" bookmarklet'ine tıklayın
3. Sayfadaki herhangi bir görsele tıklayarak incelemeye başlayın
4. Fare tekerleğini kullanarak yakınlaştırma/uzaklaştırma yapabilirsiniz
5. Görseli yeni sekmede açmak için "Görseli Aç" butonuna tıklayın
6. Modalı kapatmak için ESC tuşuna basın veya dışarıdaki karanlık alana tıklayın

### 🔴 Demo

Çalışan demo için: [tahamehel.tr/photo_zoom](https://tahamehel.tr/photo_zoom)

---

## 🇬🇧 English

### 📝 About the Project

**Photo-Zoom** is a JavaScript bookmarklet that allows you to view and zoom images on web pages with a single click. It makes it easy to examine images while searching on sites like Google Images or browsing any website.

### ✨ Features

- View any image in its original size with a single click
- Easy zoom in/out using the mouse wheel
- Option to open the image in a new tab
- Easy closing with keyboard shortcut (ESC key)
- Lightweight with no installation required

### 🚀 Installation

1. Copy the following code:
   ```javascript
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
   ```
2. Create a new bookmark in your browser
3. Paste the copied code into the URL field of the bookmark
4. Name it "Photo-Zoom" or any name you prefer
5. Save it

### 🔧 Usage

1. Navigate to a web page with images you want to examine
2. Click on the "Photo-Zoom" bookmarklet in your bookmark bar
3. Click on any image on the page to start examining it
4. Use the mouse wheel to zoom in/out
5. Click the "Open Image" button to open the image in a new tab
6. Press ESC or click on the dark area outside to close the modal

### 🔴 Demo

For a working demo: [tahamehel.tr/photo_zoom](https://tahamehel.tr/photo_zoom)

---



## 👨‍💻 Yapımcı / Developer

**Taha Mehel**

- Website: [tahamehel.tr](https://tahamehel.tr)
- GitHub: [@tahamhl](https://github.com/tahamhl) 