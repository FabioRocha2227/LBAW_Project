@extends('layouts.app')
@section('content')

<section class="d-flex  justify-content-center">
<div class="container mt-5">
  <h1 class="text-center mb-4">About Us</h1>
  <p>Welcome to our website! We are a team of developers and designers who have come together to create a unique and innovative platform for our users.</p>
  <p>Our website offers a wide range of features and functionality, including the ability to create and share content, connect with other users, and discover new and interesting things.</p>
  <p>You can create and join groups, see feeds from your friends and other users, and even customize your privacy settings to control who sees your content. Whether you want to share with just your friends or with everyone, we give you the control to decide how you want to use our platform.</p>
  <p>Whether you're looking to connect with friends and family, or just want to explore and discover new things, our website has something for everyone. We hope you enjoy using our platform and we look forward to hearing your feedback and suggestions for improvement.</p>
  <p>Thank you for choosing our website and we hope to see you again soon!</p>
</div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function() {
  // Get the footer element
  var footer = document.querySelector('.footer');
  
  // Add the fixed-bottom class to the footer element
  footer.classList.add('fixed-bottom');
});
  </script>

@endsection