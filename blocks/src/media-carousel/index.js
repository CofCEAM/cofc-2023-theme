import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from "@wordpress/block-editor";
import { PanelBody, ToggleControl, TextControl, TextareaControl, Button, Dashicon } from "@wordpress/components";
import { registerBlockType } from "@wordpress/blocks";
import metadata from "./block.json";
import MediaCarousel from "./MediaCarousel";
import { useEffect, useState } from "react";

registerBlockType(metadata.name, {
  title: "CofC Media Carousel",
  edit: ({ attributes, setAttributes, isSelected }) => {
    const [showMediaDialog, setShowMediaDialog] = useState(false);
    const [selectedMediaType, setSelectedMediaType] = useState("");
    const [videos, setVideos] = useState([]);

    const [selectedVideoId, setSelectedVideoId] = useState("");
    const [selectedVideoLink, setSelectedVideoLink] = useState("");
    const [selectedVideoTitle, setSelectedVideoTitle] = useState("");
    const [selectedVideoCaption, setSelectedVideoCaption] = useState("");
    const { title, description, mediaItems, includeLink, linkUri, linkText, linkNewTab } = attributes;

    const getRandomInt = () => {
      return Math.floor(Math.random() * 10000);
    };
    const onDescriptionChange = (newDescription) => {
      setAttributes({ description: newDescription });
    };

    useEffect(() => {
      if (mediaItems.length > 0) {
        const videoMatch = mediaItems.filter((item) => item.id === selectedVideoId);
        if (videoMatch.length > 0) {
          const vid = videoMatch[0];
          console.log("video match!");
          console.log(vid);
          setSelectedVideoCaption(vid.caption);
          setSelectedVideoTitle(vid.title);
          setSelectedVideoLink(vid.url);
        }
      }
    }, [selectedVideoId]);

    const onAddItemToCarousel = () => {
      setShowMediaDialog(true);
    };

    const onMediaDialogClose = () => {
      setShowMediaDialog(false);
      setSelectedMediaType("");
    };

    const onSelectImage = (newImage) => {
      setAttributes({ mediaItems: [...mediaItems, ...newImage] });
      onMediaDialogClose();
    };

    const onSelectVideo = (videoLink, caption, title) => {
      const videoId = getRandomInt();
      const newItem = {
        id: videoId,
        url: videoLink,
        type: "video",
        caption: caption || "",
        title: title || "",
      };
      setAttributes({ mediaItems: [...mediaItems, newItem] });
      setSelectedVideoId(videoId);
      onMediaDialogClose();
    };

    const onRemoveItem = (index) => {
      const updatedMedia = [...mediaItems];
      updatedMedia.splice(index, 1);
      setAttributes({ mediaItems: updatedMedia });
    };

    const onIncludeLinkChange = (newIncludeLink) => {
      setAttributes({ includeLink: newIncludeLink });
    };

    const onLinkTextChange = (newLinkText) => {
      setAttributes({ linkText: newLinkText });
    };
    const onLinkUriChange = (newLinkUri) => {
      setAttributes({ linkUri: newLinkUri });
    };
    const onLinkNewTabChange = (newLinkNewTab) => {
      setAttributes({ linkNewTab: newLinkNewTab });
    };
    const onTitleChange = (newTitle) => {
      setAttributes({ title: newTitle });
    };

    // Use the useBlockProps hook to apply block props to the wrapper element
    const blockProps = useBlockProps({ className: `custom-block ${isSelected ? "is-selected" : ""}` });

    return (
      <div {...blockProps}>
        <InspectorControls>
          <PanelBody title="Block Settings" initialOpen={true}>
            <p>
              Your carousel can include both images and videos. Videos must be stored on YouTube to be used in the
              carousel.
            </p>
            <TextControl
              label="Title"
              help="What should the heading above the carousel say?"
              value={title}
              onChange={onTitleChange}
            ></TextControl>
            <TextareaControl
              label="Description"
              help="What should the description below the carousel say?"
              value={description}
              onChange={onDescriptionChange}
            ></TextareaControl>
            <ToggleControl
              label="Include a link below the carousel to another page?"
              checked={includeLink}
              onChange={onIncludeLinkChange}
            />
            {includeLink ? (
              <>
                {/* ask for link settings (URI and text) */}
                <ToggleControl label="Open in a New Tab?" checked={linkNewTab} onChange={onLinkNewTabChange} />
                <TextControl
                  label="Link Text"
                  help="What text should display for the link?"
                  onChange={onLinkTextChange}
                  value={linkText}
                ></TextControl>
                <TextControl
                  label="Link URI"
                  help="Provide the URL to link to"
                  onChange={onLinkUriChange}
                  type="url"
                  value={linkUri}
                ></TextControl>
              </>
            ) : (
              ""
            )}
            {mediaItems.length > 0 ? (
              <div class="carousel-preview">
                <h3>Carousel Items:</h3>
                <hr />
                {mediaItems.map((item, index) => (
                  <div key={index} data-itemid={item["id"]}>
                    {item["type"] === "image" && (
                      <div>
                        <img src={item.url} alt="Selected Image" />
                        <Button onClick={() => onRemoveItem(index)}>
                          <Dashicon icon="trash" />
                          Remove Image
                        </Button>
                      </div>
                    )}
                    {item["type"] === "video" && (
                      <div>
                        <video id={`video-${item["id"]}`} src={item.url} controls />
                        <Button onClick={() => onRemoveItem(index)}>
                          <Dashicon icon="trash" />
                          Remove Video
                        </Button>
                      </div>
                    )}
                  </div>
                ))}
              </div>
            ) : (
              <p>No items in carousel.</p>
            )}
            <div style={{ textAlign: "center" }}>
              <Button
                className="components-button is-primary"
                style={{ margin: ".5rem" }}
                onClick={onAddItemToCarousel}
              >
                Add Item to Carousel
              </Button>
              <MediaUploadCheck>
                {showMediaDialog && (
                  <div className="media-dialog">
                    <h3>Select Media Type</h3>
                    <Button onClick={() => setSelectedMediaType("image")}>Image</Button>
                    <Button onClick={() => setSelectedMediaType("video")}>Video</Button>
                    {selectedMediaType === "image" && (
                      <MediaUpload
                        onSelect={onSelectImage}
                        allowedTypes={["image"]}
                        multiple={true}
                        gallery={false}
                        value={null}
                        render={({ open }) => (
                          <div style={{ margin: "0.5rem", display: "block" }}>
                            <br />
                            <Button className="components-button is-primary" onClick={open}>
                              <Dashicon icon="format-image" />
                              Select Image
                            </Button>
                          </div>
                        )}
                      />
                    )}
                    <Button onClick={onMediaDialogClose}>Cancel</Button>
                  </div>
                )}
              </MediaUploadCheck>
              {selectedMediaType === "video" && (
                <div className="video-fields" style={{ display: "block", margin: "1rem" }}>
                  <TextControl
                    type="url"
                    label="Video Link"
                    placeholder="Enter YouTube Video link"
                    value={selectedVideoLink}
                    onChange={(value) => {
                      setSelectedVideoLink(value);
                    }}
                  />
                  <TextareaControl
                    label="Video Caption"
                    value={selectedVideoCaption}
                    onChange={(value) => {
                      setSelectedVideoCaption(value);
                    }}
                  />
                  <TextControl
                    label="Video Title"
                    value={selectedVideoTitle}
                    onChange={(value) => {
                      setSelectedVideoTitle(value);
                    }}
                  />
                  <Button
                    className="components-button is-primary"
                    onClick={() => onSelectVideo(selectedVideoLink, selectedVideoCaption, selectedVideoTitle)}
                  >
                    Add Video
                  </Button>
                  {}
                </div>
              )}
            </div>
          </PanelBody>
        </InspectorControls>
        <div className="block-preview wp-block" style={{ border: "1px solid black", margin: "0.3rem" }}>
          <MediaCarousel attributes={attributes}></MediaCarousel>
        </div>
      </div>
    );
  },
  save: ({ attributes }) => {
    return <MediaCarousel attributes={attributes}></MediaCarousel>;
  },
});
