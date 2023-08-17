<?php

/**
 * Block Name: CofC Testimonial (Static)
 * Description: Display a grid of posts with optional filters applied
 */
function register_cofctheme_testimonial(): void
{
    register_block_type(__DIR__);
}


add_action('init', 'register_cofctheme_testimonial');