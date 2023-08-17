(function (Drupal){

document.addEventListener("DOMContentLoaded", function () {
  let checkbox = document.getElementById("checkbox");
  let lastname = document.querySelector(".form-item-lastname");

  if (checkbox.checked) {
    lastname.style.display = 'none';
  }

  checkbox.addEventListener("change", function () {
    if (this.checked) {
      lastname.style.display = 'none';
    }
    else{
      lastname.style.display = 'block';
    }
  });
});

})(Drupal);


