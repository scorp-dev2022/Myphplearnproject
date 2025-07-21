class Film {
  constructor(
    id = 0,
    title = "",
    description = "",
    imageUrl = [],
    url = "",
    isActive = false
  ) {
    this._id = id;
    this._title = title;
    this._description = description;
    this._imageUrl = imageUrl;
    this._url = url;
    this._isActive = isActive;
  }

  //  GETTERS
  get id() {
    return this._id;
  }

  get title() {
    return this._title;
  }

  get description() {
    return this._description;
  }

  get imageUrl() {
    return this._imageUrl;
  }

  get url() {
    return this._url;
  }

  get isActive() {
    return this._isActive;
  }

  //  SETTERS
  set id(value) {
    if (typeof value === "string" && value >= 0) {
      this._id = value;
    } else {
      console.warn("ID geçerli bir sayı olmalıdır.");
    }
  }

  set title(value) {
    if (typeof value === "number" || ("string" && value.trim().length > 0)) {
      this._title = value;
    } else {
      console.warn("Başlık boş olamaz.");
    }
  }

  set description(value) {
    this._description = value || "";
  }

  set imageUrl(value) {
    this._imageUrl = value;
  }

  set url(value) {
    this._url = value || "";
  }

  set isActive(value) {
    this._isActive = Boolean(value);
  }

  loadTableMovies() {
    $.ajax({
      url: "../controlers/_getfilm_con.php",
      method: "POST",
      data: { getmovie: "getmovie" },
      success: function (cevap) {
        try {
          const json = JSON.parse(cevap);
          let contents = "";
          json.forEach((element) => {
            let status = element.isActive ? "Aktif" : "Pasif";
            contents += ` <tr>
                                    <th scope="row id">${element.id}</th>
                                    <td>${element.title}</td>
                                    <td>${element.description}</td>
                                    <td>${element.imageUrl}</td>
                                    <td>${element.url}</td>
                                    <td>${status}</td>
                                    <td><a href="#" class="btn btn-primary me-2 btnselect">Düzenle</a><a href="#" class="btn btn-danger btndelete">Sil</a></td>
                                </tr>     `;
          });
          $("#loadmovietable").html(contents);
        } catch (e) {
          console.error("JSON parse hatası:", e.message);
        }
      },
      error: function () {
        alert("Hata oluştu, lütfen tekrar deneyin.");
      },
    });
  }

  loadMovies() {
    $.ajax({
      url: "../controlers/_getfilm_con.php",
      method: "POST",
      data: { getmovie: "getmovie" },
      success: function (cevap) {
        try {
          const json = JSON.parse(cevap);
          let contents = "";
          json.forEach((element) => {
            contents += `<div class="card mb-3">
              <div class="row">
                <div class="col-3">
                  <img class="img-fluid" src="${element.imageUrl}" alt="">
                </div>
                <div class="col-9">
                  <div class="card-body">
                    <h5 class="card-title">${element.title}</h5>
                    <p class="card-text">${element.description}</p>
                    <div>
                      <span class="badge bg-primary">350</span>
                      <span class="badge bg-primary">500</span>
                      <span class="badge bg-warning">Vizyonda</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>`;
          });
          $("#loadmovie").html(contents);
        } catch (e) {
          console.error("JSON parse hatası:", e.message);
        }
      },
      error: function () {
        alert("Hata oluştu, lütfen tekrar deneyin.");
      },
    });
  }

  addfilm() {
    const formdata = new FormData();

    for (let i = 0; i < this.imageUrl.length; i++) {
      formdata.append("images[]", this.imageUrl[i]);
    }

    const durum = $("#activerad").is(":checked")
      ? "0"
      : $("#pasifrad").is(":checked")
      ? "1"
      : "0";

    formdata.append("baslik", this.title);
    formdata.append("aciklama", this.description);
    formdata.append("url", this.url);
    formdata.append("durum", durum);
    formdata.append("addmovie", "addmovie");

    $.ajax({
      url: "../controlers/_getfilm_con.php",
      method: "POST",
      data: formdata,
      processData: false,
      contentType: false,
      success: (cevap) => {
        if (cevap.trim() === "success") {
          console.log("Film başarıyla eklendi.");
        } else {
          console.error("Hata:", cevap.trim());
        }
      },
      error: () => {
        alert("Sunucu hatası, lütfen tekrar deneyin.");
      },
    });
  }

  updatefilm() {
    const formdata = new FormData();

    for (let i = 0; i < this.imageUrl.length; i++) {
      formdata.append("images[]", this.imageUrl[i]);
    }

    const durum = $("#activerad").is(":checked") ? "1" : "0";

    formdata.append("baslik", this.title);
    formdata.append("aciklama", this.description);
    formdata.append("url", this.url);
    formdata.append("durum", durum);
    formdata.append("id", this.id);
    formdata.append("updatemovie", "updatemovie");

    $.ajax({
      url: "../controlers/_getfilm_con.php",
      method: "POST",
      data: formdata,
      processData: false,
      contentType: false,
      success: (cevap) => {
        cevap = cevap.trim();
        if (cevap === "success") {
          alert("Film başarıyla güncellendi.");
        } else if (cevap === "kayit var") {
          alert("Bu URL zaten kayıtlı.");
        } else {
          console.error("Sunucu cevabı:", cevap);
          alert("Güncelleme başarısız oldu.");
        }
      },
      error: () => {
        alert("Sunucu hatası, lütfen tekrar deneyin.");
      },
    });
  }

  deletefilm() {
    return new Promise((resolve, reject) => {
      const formdata = new FormData();
      formdata.append("iddelete", this.id);

      $.ajax({
        url: "../controlers/_getfilm_con.php",
        method: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: (cevap) => {
          if (cevap.trim() === "success") {
            resolve("success");
          } else {
            resolve("error");
          }
        },
        error: () => {
          reject("Sunucu hatası");
        },
      });
    });
  }

  eventHandler(callback, butons, fnctyps) {
    const tableBody = document.getElementById("loadmovietable");
    const film = this;

    tableBody.addEventListener("click", async function (e) {
      if (e.target.classList.contains(butons)) {
        e.preventDefault();

        const row = e.target.closest("tr");
        const idCell = row.querySelector("th");
        const idValue = idCell ? idCell.textContent.trim() : null;
        film.id = idValue;

        const tdCells = row.querySelectorAll("td");
        const data = [];

        tdCells.forEach((cell) => {
          const cellText = cell.textContent.trim();
          data.push(cellText);
        });

        if (fnctyps === "delete" && butons === "btndelete") {
          const result = await film.deletefilm();
          callback(result);
        } else if (fnctyps === "select" && butons === "btnselect") {
          callback(data);
        }
      }
    });
  }
}
