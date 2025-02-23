
//слайдер

const sliderBox = document.querySelectorAll(".slide"),
  sliderLine = document.querySelector(".slider__line"),

  sliderBtnNext = document.querySelector(".slider__button-next"),
  sliderBtnPrev = document.querySelector(".slider__button-prev");

let sliderCount = 0,
  sliderWidth;

window.addEventListener("resize", showSlide);

sliderBtnNext.addEventListener("click", nextSlide);
sliderBtnPrev.addEventListener("click", prevSlide);

function showSlide() {
  sliderWidth = document.querySelector(".slider").offsetWidth;
  sliderBox.forEach((item) => (item.style.width = sliderWidth + "px"));
  rollSlider();
}

showSlide();

function nextSlide() {
  sliderCount++;
  if (sliderCount >= sliderBox.length) sliderCount = 0;
  rollSlider();
   
}
function prevSlide() {
  sliderCount--;
  if (sliderCount < 0) sliderCount = sliderBox.length - 1;
  rollSlider();
  
}

function rollSlider() {
  sliderLine.style.transform = `translateX(${-sliderCount * sliderWidth}px)`;
}

console.log(sliderBox);