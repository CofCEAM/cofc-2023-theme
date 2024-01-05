<?php

/**
 * Block Name: CofC Podcast Platforms (Static)
 * Description: Display podcast platforms list 
 */
function register_cofctheme_podcast_platforms(): void
{
    register_block_type(
        __DIR__
    );
}


add_action('init', 'register_cofctheme_podcast_platforms');