import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from "@wordpress/block-editor";
import { PanelBody, ToggleControl, TextControl, TextareaControl, Button, Dashicon } from "@wordpress/components";
import { registerBlockType } from "@wordpress/blocks";
import metadata from "./block.json";
import MediaCarousel from "./MediaCarousel";
import { useEffect, useState } from "react";

const EditVideoFields = ({
  onSelectVideo,
  selectedVideoLink,
  selectedVideoCaption,
  selectedVideoTitle,
  setSelectedVideoLink,
  setSelectedVideoCaption,
  setSelectedVideoTitle,
}) => {
  return (
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
        onClick={() => {
          onSelectVideo(selectedVideoLink, selectedVideoCaption, selectedVideoTitle);
        }}
      >
        Save Video
      </Button>
    </div>
  );
};

registerBlockType(metadata.name, {
  title: "CofC Media Carousel",
  edit: ({ attributes, setAttributes, isSelected }) => {
    const [showMediaDialog, setShowMediaDialog] = useState(false);
    const [selectedMediaType, setSelectedMediaType] = useState("");
    const [editingItemId, setEditingItemId] = useState(null);
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
      if (editingItemId) {
        let itemToChange = mediaItems.filter((item) => item.id === editingItemId)[0];
        itemToChange.caption = caption;
        itemToChange.title = title;
        itemToChange.url = videoLink;
        const updatedMedia = [...mediaItems];
        updatedMedia.splice(mediaItems.indexOf(itemToChange), 1, itemToChange);
        setAttributes({ mediaItems: updatedMedia });
        setEditingItemId(null);
      } else {
        // new addition
        const videoId = getRandomInt();
        const newItem = {
          id: videoId,
          url: videoLink,
          type: "video",
          caption: caption || "",
          title: title || "",
        };
        setAttributes({ mediaItems: [...mediaItems, newItem] });
        onMediaDialogClose();
      }
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
                  <div
                    style={{
                      marginBottom: "1rem",
                      borderBottom: "1px solid blue",
                      paddingBottom: "1rem",
                    }}
                    key={index}
                    className="carousel-item-preview"
                    draggable="true"
                    onDragStart={(event) => {
                      event.dataTransfer.setData("text/plain", index);
                    }}
                    onDragOver={(event) => {
                      event.preventDefault();
                    }}
                    onDrop={(event) => {
                      const draggedIndex = event.dataTransfer.getData("text/plain");
                      const droppedIndex = index;

                      const newMediaItems = [...mediaItems];
                      const temp = newMediaItems[draggedIndex];
                      newMediaItems[draggedIndex] = newMediaItems[droppedIndex];
                      newMediaItems[droppedIndex] = temp;

                      setAttributes({ mediaItems: newMediaItems });
                    }}
                    data-itemid={item["id"]}
                  >
                    {item["type"] === "image" && (
                      <div>
                        <img src={item.url} alt="Selected Image" />
                        <div
                          style={{
                            display: "block",
                            margin: "0.5rem 0",
                          }}
                        >
                          <h4>{item.title}</h4>
                          <p>{item.caption}</p>
                        </div>
                        <Button className="components-button is-destructive" onClick={() => onRemoveItem(index)}>
                          <Dashicon icon="trash" />
                          Remove Image
                        </Button>
                      </div>
                    )}
                    {item["type"] === "video" && editingItemId !== item.id && (
                      /* not editing this video so preview it */
                      <div>
                        <video id={`video-${item.id}`} src={item.url} controls />
                        <div
                          style={{
                            display: "block",
                            margin: "0.5rem 0",
                          }}
                        >
                          <h4>{item.title}</h4>
                          <p>{item.caption}</p>
                        </div>
                        <div
                          style={{
                            display: "flex",
                            justifyContent: "space-between",
                            alignItems: "center",
                            margin: "0.5rem 0",
                          }}
                        >
                          <Button className="components-button is-destructive" onClick={() => onRemoveItem(index)}>
                            <Dashicon icon="trash" />
                            Remove Video
                          </Button>
                          <Button
                            className="components-button is-primary"
                            onClick={() => {
                              setEditingItemId(item.id);
                              setSelectedVideoLink(item.url);
                              setSelectedVideoTitle(item.title);
                              setSelectedVideoCaption(item.caption);
                            }}
                          >
                            <Dashicon icon="edit" />
                            Edit Video Info
                          </Button>
                        </div>
                      </div>
                    )}
                    {item["type"] === "video" && editingItemId === item.id && (
                      /* editing this video so show the edit fields */
                      <div>
                        <EditVideoFields
                          onSelectVideo={onSelectVideo}
                          selectedVideoCaption={selectedVideoCaption}
                          selectedVideoLink={selectedVideoLink}
                          selectedVideoTitle={selectedVideoTitle}
                          setSelectedVideoCaption={setSelectedVideoCaption}
                          setSelectedVideoLink={setSelectedVideoLink}
                          setSelectedVideoTitle={setSelectedVideoTitle}
                        ></EditVideoFields>
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
              {selectedMediaType === "video" && <EditVideoFields onSelectVideo={onSelectVideo}></EditVideoFields>}
            </div>
          </PanelBody>
        </InspectorControls>
        <div className="block-preview wp-block" style={{ border: "1px solid black", margin: "0.3rem" }}>
          <div>
            <code>PREVIEW PAGE TO VIEW MEDIA CAROUSEL "{title}"</code>
          </div>
        </div>
      </div>
    );
  },
  save: ({ attributes }) => {
    return <MediaCarousel attributes={attributes}></MediaCarousel>;
  },
});
