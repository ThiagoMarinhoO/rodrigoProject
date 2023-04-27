<?php 
get_header();

global $post;

?>

<?php 
    $obj = get_queried_object();
    $postType = $obj->post_type;
    $slug = $obj->post_name;
    $default = get_template_directory() . '/404.php';
    $page = get_template_directory() . '/template-parts/' . $postType . '/' . $slug . '.php';

    if ( file_exists( $page ) ) {
        include($page);
    }       
    else { 
        include($default);
    }

?>


<?php 
get_footer();
?>