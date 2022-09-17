
</div> <!-- super container ends -->
<footer>


</footer>


<?php
if(!is_user_logged_in()){
    get_template_part('template-parts/login-register/index');
}

?>

<?php
    get_template_part('template-parts/components/ajax', 'overlay');
    get_template_part('template-parts/components/ajax', 'toast');
    get_template_part('template-parts/components/modal', 'confirm');
    get_template_part('template-parts/components/modal', 'alert');

?>



<?php wp_footer(); ?>


</body>
</html>