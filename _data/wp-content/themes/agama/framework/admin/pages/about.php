<?php
/**
 * About
 *
 * The Agama admin menu page.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.1
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<div class="wrap about-wrap agama-wrap">
    
    <div class="agama-head">
        <h1><?php printf( '%s <span>%s %s</span>', __( 'Agama', 'agama' ), __( 'Version', 'agama' ), Agama()->version() ); ?></h1>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <div class="paypal-donations">
                <input type="hidden" name="cmd" value="_donations">
                <input type="hidden" name="bn" value="TipsandTricks_SP">
                <input type="hidden" name="business" value="paypal@theme-vision.com">
                <input type="hidden" name="return" value="https://www.theme-vision.com/thank-you/">
                <input type="hidden" name="item_name" value="Agama development support.">
                <input type="hidden" name="rm" value="0">
                <input type="hidden" name="currency_code" value="USD">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online.">
                <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" style="height: 1px;">
            </div>
        </form>
    </div>
    
    <div class="agama-card mb-50">
        <div class="agama-card-body">
            <div class="full-width-layout">
                <h3 class="aligncenter heading-pro">Why Agama?</h3>
                <div class="has-3-columns">
                    
                    <div class="agama-icon-box column aligncenter">
                        <div class="agama-icon-box-icon">
                            <i class="fe-icon-code"></i>
                        </div>
                        <h3 class="agama-icon-box-title"><?php _e( 'Customizable', 'agama' ); ?></h3>
                        <p class="agama-icon-box-text"><?php _e( 'The Agama theme is build in mind to be easily customizable/extendable by amateurs or skilled developers.', 'agama' ); ?></p>
                        <a href="https://theme-vision.com/agama/" class="agama-icon-box-link" target="_blank">
                            <?php _e( 'Learn more', 'agama' ); ?> <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="agama-icon-box column aligncenter">
                        <div class="agama-icon-box-icon">
                            <i class="fe-icon-globe"></i>
                        </div>
                        <h3 class="agama-icon-box-title"><?php _e( 'Multilanguage', 'agama' ); ?></h3>
                        <p class="agama-icon-box-text"><?php _e( 'The Agama theme is translated to multiple languages already such as Spanish, Russian & German.', 'agama' ); ?></p>
                        <a href="https://theme-vision.com/agama/" class="agama-icon-box-link" target="_blank">
                            <?php _e( 'Learn more', 'agama' ); ?> <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="agama-icon-box column aligncenter">
                        <div class="agama-icon-box-icon">
                            <i class="fe-icon-heart"></i>
                        </div>
                        <h3 class="agama-icon-box-title">Coded with Love</h3>
                        <p class="agama-icon-box-text"><?php _e( 'The Agama theme is coded with passion and love. More than 5 years of development says more than thousands words.', 'agama' ); ?></p>
                        <a href="https://theme-vision.com/agama/" class="agama-icon-box-link" target="_blank">
                            <?php _e( 'Learn more', 'agama' ); ?> <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</div><!-- .agama-wrap -->
