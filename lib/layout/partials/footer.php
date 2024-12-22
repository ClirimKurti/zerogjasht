<?php

add_action('genesis_footer', 'custom_footer', 8);
add_action('genesis_before_footer', 'footer_form', 11);

function footer_form()
{ ?>

<?php
}

function custom_footer()
{
    remove_action('genesis_footer', 'genesis_do_footer', 10);
    if (!is_page_template('templates/contact-template.php') && !is_front_page()) {
        get_template_part('lib/modules/contact');
    }
    if (!is_front_page()) {
        get_template_part('lib/modules/faq');
    }
    global $hc_settings;
?>
    <div class="footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div class="footer-info">
                        <a href="<?php echo site_url(); ?>" class="footer-logotype" title="<?php echo get_bloginfo('name'); ?>">
                            <picture>
                                <img src="<?= CHILD_URL ?>/assets/app/img/zero-gjasht.webp" alt="<?= get_bloginfo('name'); ?>" title="<?= get_bloginfo('name'); ?>" width="250" height="90">
                            </picture>
                        </a>
                    </div>
                    <div class="socials-links border-none pt-2">
                        <div class="container">
                            <div class="row">
                                <div class="d-flex mt-4 d-none d-xl-flex col-lg-12">
                                    <div class="social-share">
                                        <a class="social-share-instagram" href="" title="Instagram" target="_blank"><?= do_shortcode('[icon name="instagram"]'); ?></a>
                                        <a class="social-share-facebook" href="" title="Facebook" target="_blank"><?= do_shortcode('[icon name="facebook"]'); ?></a>
                                        <a class="social-share-youtube" href="" title="Youtube" target="_blank"><?= do_shortcode('[icon name="youtube "]'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 ms-xl-5">
                    <p class="font-oswald">Materialet e publikuara në këtë platformë, përfshirë shkrimet dhe fotografitë, mund të përdoren vetëm duke cituar burimin zerogjasht.com. Çdo përdorim ose riprodhim i tyre pa pëlqimin paraprak të albinfo.ch është i ndaluar dhe konsiderohet shkelje e të drejtave të autorit. Redaksia rezervon të drejtën për të mos publikuar ose kthyer dorëshkrimet, fotografitë apo materialet tjera të dërguara.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <div class="footer-copyright-text">
                    <p>&copy; Copyright <?= date('Y'); ?> <a href="<?= site_url(); ?>" title="<?= bloginfo('title'); ?>"><?= bloginfo('title'); ?></a>. Të gjitha të drejtat e rezervuara.</p>
                </div>
            </div>
        </div>
    </div>
    </div>

    <button type="button" name="scroll-to-up" aria-label="scroll to up" id="scrollToTop" class="btn-up"><?php echo do_shortcode('[icon name="arrow-down"]'); ?></button>

    <div id="modal-container"></div>

<?php
}
