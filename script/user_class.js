class Users {
  constructor(
    id = 0,
    name = "",
    surname = "",
    username = "",
    password = "",
    role = ""
  ) {
    this._id = id;
    this._name = name;
    this._surname = surname;
    this._username = username;
    this._password = password;
    this._role = role;
  }

  // GETTERS
  get getId() {
    return this.id;
  }

  get getName() {
    return this.name;
  }

  get getSurname() {
    return this.surname;
  }

  get getUsername() {
    return this.username;
  }

  get getPassword() {
    return this.password;
  }

  get getRole() {
    return this.role;
  }

  // SETTERS
  set setId(value) {
    if (typeof value == "number" || ("string" && value >= 0)) {
      this.id = value;
    } else {
      console.warn("ID geçerli bir sayı olmalıdır.");
    }
  }

  set setName(value) {
    this.name = value || "";
  }

  set setSurname(value) {
    this.surname = value || "";
  }

  set setUsername(value) {
    if (typeof value === "string" && value.trim() !== "") {
      this.username = value;
    } else {
      console.warn("Kullanıcı adı boş olamaz.");
    }
  }

  set setPassword(value) {
    if (typeof value === "string" && value.length >= 3) {
      this.password = value;
    } else {
      console.warn("Şifre en az 4 karakter olmalıdır.");
    }
  }

  set setRole(value) {
    this.role = value || "";
  }

  loadTableUsers() {
    $.ajax({
      url: "../controlers/_user_con.php",
      method: "POST",
      data: { getuser: "getuser" },
      success: function (cevap) {
        try {
          const json = JSON.parse(cevap);
          let contents = "";
          json.forEach((element) => {
            contents += ` <tr>
                                    <th scope="row id">${element.id}</th>
                                    <td>${element.username}</td>  
                                    <td><a href="#" class="btn btn-primary me-2 btnselect">Düzenle</a><a href="#" class="btn btn-danger btndelete">Sil</a></td>
                                </tr>     `;
          });
          $("#loadusertable").html(contents);
        } catch (e) {
          console.error("JSON parse hatası:", e.message);
        }
      },
      error: function () {
        alert("Hata oluştu, lütfen tekrar deneyin.");
      },
    });
  }

  login() {
    $.ajax({
      url: "../controlers/_user_con.php",
      method: "POST",
      data: {
        username: this.getUsername,
        password: this.getPassword,
      },
      success: function (response) {
        try {
          if (response == "success") {
            window.location.href = "index.php";
          } else {
            alert("Kullanıcı adı veya şifre hatalı!");
          }

          console.log(response);
        } catch (e) {
          alert("Giriş kontrolü başarısız: " + e.message);
        }
      },
      error: function () {
        alert("Sunucuya erişilemedi. Lütfen tekrar deneyin.");
      },
    });
  }

  adduser(username, password) {
    $.ajax({
      url: "../controlers/_user_con.php",
      method: "POST",
      data: {
        usernameadd: username,
        passwordadd: password,
      },
      success: function (response) {
        try {
          if (response === "success") {
            window.location.href = "index.php";
          } else {
            alert("Kullanıcı adı veya şifre hatalı!");
          }
        } catch (e) {
          alert("Giriş kontrolü başarısız: " + e.message);
        }
      },
      error: function () {
        alert("Sunucuya erişilemedi. Lütfen tekrar deneyin.");
      },
    });
  }

  updateuser() {
    $.ajax({
      url: "../controlers/_user_con.php",
      method: "POST",
      data: {
        usernameupdate: this.getUsername,
        passwordupdate: this.getPassword,
        id: this.getId
      },
      success: function (response) {
        try {
          if (response === "success") {
            alert("Kullanıcı başarıyla güncellendi");
          } else {
            alert("Kullanıcı adı veya şifre hatalı!");
          }
        } catch (e) {
          alert("Giriş kontrolü başarısız: " + e.message);
        }
      },
      error: function () {
        alert("Sunucuya erişilemedi. Lütfen tekrar deneyin.");
      },
    });
  }

  logout() {
    $.ajax({
      url: "../controlers/_user_con.php",
      method: "POST",
      data: {
        logout: "logout",
      },
      success: function (response) {
        try {
          if (response == "logedout") {
            window.location.href = "index.php";
          } else {
            alert("hata!");
          }

          console.log(response);
        } catch (e) {
          alert("Giriş kontrolü başarısız: " + e.message);
        }
      },
      error: function () {
        alert("Sunucuya erişilemedi. Lütfen tekrar deneyin.");
      },
    });
  }

  deleteuser() {
    return new Promise((resolve, reject) => {
      const formdata = new FormData();
      formdata.append("iddelete", this.getId);

      $.ajax({
        url: "../controlers/_user_con.php",
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
    const tableBody = document.getElementById("loadusertable");
    const user = this;

    tableBody.addEventListener("click", async function (e) {
      if (e.target.classList.contains(butons)) {
        e.preventDefault();

        const row = e.target.closest("tr");
        const idCell = row.querySelector("th");
        const idValue = idCell ? idCell.textContent.trim() : null;
        user.setId = idValue;

        const tdCells = row.querySelectorAll("td");
        const data = [];

        tdCells.forEach((cell) => {
          const cellText = cell.textContent.trim();
          data.push(cellText);
        });

        if (fnctyps === "delete" && butons === "btndelete") {
          const result = await user.deleteuser();
          callback(result);
        } else if (fnctyps === "select" && butons === "btnselect") {
          callback(data);
        }
      }
    });
  }
}
