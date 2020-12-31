const decrement = document.querySelector("#decrementButton");
const increment = document.querySelector("#incrementButton");
const container = document.querySelector("#container");

increment.addEventListener("click", scrolling);
decrement.addEventListener("click", scrolling);

async function scrolling (event) {
    event.preventDefault();
    const get = event.target.getAttribute("value");
    const response = await fetch(`/app/ajax/scrollingMonth.php?month=${get}`);
    text = await response.text();
    console.log(text);
    container.innerHTML=text;
}