document.addEventListener("DOMContentLoaded", function () {
  const showModalButton1 = document.getElementById("showModalButton1");
  const closeModalButton1 = document.getElementById("closeModalButton1");
  const customModal1 = document.getElementById("manualModal");

  const showModalButton2 = document.getElementById("showModalButton2");
  const closeModalButton2 = document.getElementById("closeModalButton2");
  const customModal2 = document.getElementById("faqModal");

  showModalButton1.addEventListener("click", function () {
    customModal1.style.display = "block";
    document.body.style.overflow = "hidden";
  });

  closeModalButton1.addEventListener("click", function () {
    customModal1.style.display = "none";
    document.body.style.overflow = "auto";
  });

  showModalButton2.addEventListener("click", function () {
    customModal2.style.display = "block";
    document.body.style.overflow = "hidden";
  });

  closeModalButton2.addEventListener("click", function () {
    customModal2.style.display = "none";
    document.body.style.overflow = "auto";
  });

  window.addEventListener("click", function (event) {
    if (event.target === customModal1) {
      customModal1.style.display = "none";
      document.body.style.overflow = "auto";
    }
    if (event.target === customModal2) {
      customModal2.style.display = "none";
      document.body.style.overflow = "auto";
    }
  });
});
