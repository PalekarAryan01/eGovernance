// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

// click events for cards
// Go to Upload Page
function gotoUploadPage(){
  window.location.href='formdetails.php';
}
// for admin search fees
function gotofetchStudent(){
  window.location.href='fetchDetail.html';
}
// for student fees
function gotofeespage(){
  window.location.href='fees_page.php';
}

function gotoWalletPage(){
  window.location.href='wallet.php';
}

function gotodisplaynotice(){
  window.location.href='display_notices.php';
}

function gotoReviewPage(){
  window.location.href='review_document.php';
}
// -------------------Add-Book-------------------------
function handleSubmit(event) {
  // Prevent the default form submission
  event.preventDefault();

  // Display the alert message
  alert('Book has been added successfully!');

  // After showing the alert, submit the form programmatically
  document.getElementById('bookForm').submit();
}


function handleUser(event) {
  // Prevent the default form submission
  event.preventDefault();

  // Display the alert message
  alert('User has been added successfully!');

  // After showing the alert, submit the form programmatically
  document.getElementById('addUser').submit();
}

// Reserve====================
// function reserveBook(book_id, user_name) {
//     let form = document.createElement('form');
//     form.method = 'POST';
//     form.action = 'reserve.php';

//     let bookInput = document.createElement('input');
//     bookInput.type = 'hidden';
//     bookInput.name = 'book_id';
//     bookInput.value = book_id;
//     form.appendChild(bookInput);

//     let userInput = document.createElement('input');
//     userInput.type = 'hidden';
//     userInput.name = 'user_name';
//     userInput.value = user_name;
//     form.appendChild(userInput);

//     document.body.appendChild(form);
//     form.submit();
// }


function reserveBook(book_id) {
  let user_name = "<?php echo isset($_SESSION['Fname']) ? $_SESSION['Fname'] : 'Guest'; ?>";
  let checkout_time = prompt("Please enter the checkout time (HH:MM):");

  if (checkout_time) {
      let form = document.createElement('form');
      form.method = 'POST';
      form.action = 'reserve.php';

      let bookInput = document.createElement('input');
      bookInput.type = 'hidden';
      bookInput.name = 'book_id';
      bookInput.value = book_id;
      form.appendChild(bookInput);

      let userInput = document.createElement('input');
      userInput.type = 'hidden';
      userInput.name = 'user_name';
      userInput.value = user_name;
      form.appendChild(userInput);

      let timeInput = document.createElement('input');
      timeInput.type = 'hidden';
      timeInput.name = 'checkout_time';
      timeInput.value = checkout_time;
      form.appendChild(timeInput);

      document.body.appendChild(form);
      form.submit();
  } else {
      alert("Checkout time is required to reserve the book.");
  }
}