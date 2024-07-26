const editBtn = document.querySelector("#edit-btn");

editBtn.addEventListener("click", () => {
  let tr = editBtn.closest("tr");

  var data = Array.from(tr.children).map(function (td) {
    return td.textContent;
  });
  console.log(data);

  document.getElementById("id").value = data[0];
  document.getElementById("site").value = data[1];
  document.getElementById("username").value = data[2];
  document.getElementById("password").value = data[3];
});
