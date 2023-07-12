<?php
session_start();
include('layouts/header.php')
?>

<head>
  <style>
    #contact span {
      color: #fb774b;
    }
  </style>
</head>




<!-- Contact -->

<section id="contact" class="container-fluid my-5 py-5">
  <div class="container-fluid text-center mt-5">
    <h3>Contact us</h3>
    <hr class="mx-auto">
    <p class="w-50 mx-auto">
      Phone: <span>0988880804</span>
    </p>
    <p class="w-50 mx-auto">
      Email address: <span>hristovbaychev@gmail.com</span>
    </p>
    <p class="w-50 mx-auto">
      We work 24/7 to answer your question
    </p>
  </div>
</section>






<script>
  var mainImg = document.getElementById("mainImg");
  var smallImg = document.getElementsByClassName("small-image"); // return array [0,1,2,3]

  for (let i = 0; i < 4; i++) {
    smallImg[i].onclick = function() { // listen for click for small img
      mainImg.src = smallImg[i].src; // replaced 
    }
  }
</script>


<?php include('layouts/footer.php');?>