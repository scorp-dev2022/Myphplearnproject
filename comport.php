<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>COM Port Seçici</title>
  <style>
    #modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
    }
    .modal-content {
      background: white;
      margin: 10% auto;
      padding: 20px;
      width: 300px;
      border-radius: 8px;
    }
    .port-btn {
      display: block;
      margin: 10px 0;
      padding: 8px;
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>

<button id="usbBtn">USB Cihazı Seç ve Bağlan</button>

<div id="modal">
  <div class="modal-content" id="portList">
    <h3>COM Port Seç</h3>
    <!-- Port butonları buraya eklenecek -->
  </div>
</div>



<script>
document.getElementById("usbBtn").addEventListener("click", async () => {
  if (!("usb" in navigator)) {
    alert("Tarayıcınız WebUSB API'yi desteklemiyor.");
    return;
  }

  try {
    const device = await navigator.usb.requestDevice({
      filters: [] // Tüm cihazları gösterir, istersen vendorId/productId ile filtreleyebilirsin
    });

    await device.open(); // Cihazı aç
    if (device.configuration === null) {
      await device.selectConfiguration(1);
    }
    await device.claimInterface(0); // Genellikle 0. arayüzdür

    alert(`Bağlantı başarılı: ${device.productName}`);
    console.log("USB cihaz bilgisi:", device);

    // Burada veri gönderme/alma işlemleri yapılabilir

  } catch (err) {
    console.error("Bağlantı hatası:", err);
    alert("Bağlantı başarısız: " + err.message);
  }
});
</script>
</body>
</html>