<header>
<link rel="stylesheet" href="style.css">

<a href="home.php">Home</a>
<a href="#">FAQ</a>
<a href="#" onclick="scrollToBottom()">Contact Us</a>

<script>
    function scrollToBottom() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
        });
    }
</script>

</header>