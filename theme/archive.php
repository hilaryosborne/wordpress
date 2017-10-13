<?php get_header(); ?>

  <?php get_partial('partials/page','header'); ?>

  <?php while (have_posts()) : the_post(); ?>
    <?php get_partial('partials/page','content'); ?>
  <?php endwhile ?>

  <?php get_partial('partials/page','footer'); ?>

<?php get_footer(); ?>
