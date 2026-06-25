<?php
$postsClass = new post();
$important_posts = $postsClass->getPosts( 'post' , 5 );
if( !$important_posts || !count($important_posts) ) return;
?>

<div class="sidebar-box">
    <h3 class="sidebar-box__title bold fs-18">Important Posts</h3>
    <div class="sidebar-posts">
        <?php foreach( $important_posts as $post ):
            set_query_var("post_id" , $post->ID);
            get_template_part("template-parts/post/post-card" , "simple");
        endforeach; ?>
    </div>
</div>
