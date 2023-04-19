
<script src="js/sweetalert2.all.min.js"></script>

<?php

    $actualPage = getPageName();

    if($actualPage === 'create-user' || $actualPage === 'login'){
        echo '<script src="js/form.js"></script>';
    } else {
        echo '<script src="js/scripts.js"></script>';
    }

?>


</body>
</html>