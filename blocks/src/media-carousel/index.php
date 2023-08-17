<?php

/**
 * Block Name: CofC Media Carousel (Static)
 * Description: Display a media carousel with images and videos
 */
function register_cofctheme_carousel(): void
{
    register_block_type(
        __DIR__
    );
}


add_action('init', 'register_cofctheme_carousel');