class Category {
  name;

  constructor(name = "") {
    this.name = name;
  }

  getcategory() {
    $.ajax({
      url: "./controlers/_getcategory_con.php",
      method: "POST",
      data: { getcategory: "getcategory" },
      dataType: "json",
      success: function (json) {
        let contents = "";
        json.forEach((element) => {
          contents += ` <li class='list-group-item'>${element.name}</li>`;
        });
        $("#loadcategory").html(contents);
        
      },
      error: function (xhr) {
        console.error("Veri alınırken hata:", xhr.responseText);
      },
    });
  }

  addcategory(name) {
    $.ajax({
      url: "./controlers/_getcategory_con.php",
      method: "POST",
      data: { addcategory: (this.name = name) },
      dataType: "json",
      success: function (json) {
        alert(json.message);
        loadCategorys();
      },
      error: function (xhr) {
        console.error("Kategori eklenirken hata:", xhr.responseText);
      },
    });
  }

  devreDisiBirak() {
    this.durum = "pasif";
  }
}
