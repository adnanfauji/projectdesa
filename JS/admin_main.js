// Add hoverd class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink(event) {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  event.currentTarget.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));



// menu toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};