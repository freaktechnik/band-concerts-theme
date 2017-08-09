</main>
<?php if(is_active_sidebar('footer')) { ?>
    <footer>
        <div class="wrapper footer-inner">
            <?php dynamic_sidebar('footer'); ?>
        </div>
    </footer>
<?php }
wp_footer(); ?>
</body>
</html>
