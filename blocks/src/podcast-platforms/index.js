import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import { PanelBody, TextControl } from "@wordpress/components";
import { registerBlockType } from "@wordpress/blocks";
import metadata from "./block.json";
import PodcastPlatforms from "./PodcastPlatforms";
import React from "react";

registerBlockType(metadata.name, {
  title: "CofC Podcast Platforms",
  edit: ({ attributes, setAttributes, isSelected }) => {
    const { title, apple, google, spotify, stitcher, iheart } = attributes;

    const onTitleChange = (newTitle) => {
      setAttributes({ title: newTitle });
    };

    const onAppleChange = (newApple) => {
      setAttributes({ apple: newApple });
    };

    const onGoogleChange = (newGoogle) => {
      setAttributes({ google: newGoogle });
    };

    const onSpotifyChange = (newSpotify) => {
      setAttributes({ spotify: newSpotify });
    };

    const onStitcherChange = (newStitcher) => {
      setAttributes({ stitcher: newStitcher });
    };

    const onIheartChange = (newIheart) => {
      setAttributes({ iheart: newIheart });
    };

    // Use the useBlockProps hook to apply block props to the wrapper element
    const blockProps = useBlockProps({ className: `custom-block ${isSelected ? "is-selected" : ""}` });

    return (
      <div {...blockProps}>
        <InspectorControls>
          <PanelBody title="Block Settings" initialOpen={true}>
            <p>
              Provide links to your podcast on various platforms. If you leave a field blank, the link will not display.
            </p>
            <TextControl
              label="Title"
              help="What should the heading above the podcast platforms say?"
              value={title}
              onChange={onTitleChange}
            ></TextControl>
            <TextControl
              label="Apple Podcasts"
              help="Provide your Apple Podcasts link (will not display if empty)"
              value={apple}
              type="url"
              onChange={onAppleChange}
            ></TextControl>
            <TextControl
              label="Google Podcasts"
              help="Provide your Google Podcasts link (will not display if empty)"
              value={google}
              type="url"
              onChange={onGoogleChange}
            ></TextControl>
            <TextControl
              label="Spotify"
              help="Provide your Spotify link (will not display if empty)"
              value={spotify}
              type="url"
              onChange={onSpotifyChange}
            ></TextControl>
            <TextControl
              label="Stitcher"
              help="Provide your Stitcher link (will not display if empty)"
              value={stitcher}
              type="url"
              onChange={onStitcherChange}
            ></TextControl>
            <TextControl
              label="iHeartRadio"
              help="Provide your iHeartRadio link (will not display if empty)"
              value={iheart}
              type="url"
              onChange={onIheartChange}
            ></TextControl>
          </PanelBody>
        </InspectorControls>
        <div className="block-preview wp-block" style={{ border: "1px solid black", margin: "0.3rem" }}>
          <PodcastPlatforms attributes={attributes}></PodcastPlatforms>
        </div>
      </div>
    );
  },
  save: ({ attributes }) => {
    return <PodcastPlatforms attributes={attributes}></PodcastPlatforms>;
  },
});
