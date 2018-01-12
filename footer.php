    </div>
</main>
<?php if(is_active_sidebar('footer')) { ?>
    <footer>
        <div class="wrapper footer-inner">
            <aside>
                <?php dynamic_sidebar('footer'); ?>
            </aside>
            <aside>
                <?php dynamic_sidebar('footer2'); ?>
            </aside>
            <aside>
                <?php dynamic_sidebar('footer3'); ?>
            </aside>
        </div>
    </footer>
<?php }
wp_footer(); ?>
</body>
</html>
