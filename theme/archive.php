<?php get_header(); ?>

  <?php get_template_part('partials/page','header'); ?>

  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('partials/page','content'); ?>
  <?php endwhile ?>

  <?php get_template_part('partials/page','footer'); ?>

<?php get_footer(); ?>
