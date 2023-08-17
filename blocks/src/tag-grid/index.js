import { InspectorControls, useBlockProps, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { PanelBody, RangeControl, SelectControl, ToggleControl, TextControl } from "@wordpress/components";
import { registerBlockType } from "@wordpress/blocks";
import metadata from "./block.json";
import TagGrid from "./TagGrid";
import { TextareaControl } from "@wordpress/components";

registerBlockType(metadata.name, {
  title: "CofC Tag Grid",
  edit: ({ attributes, setAttributes, isSelected }) => {
    const tagsList = useSelect(
      (select) => select("core").getEntityRecords("taxonomy", "post_tag", { per_page: -1 }),
      []
    );
    const { tags, columns, title, includeLink, linkUri, linkText, linkNewTab } = attributes;

    const onTitleChange = (newTitle) => {
      setAttributes({ title: newTitle });
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

    const onTagsChange = (newTagIds) => {
      newTagIds = newTagIds.map((id) => parseInt(id));
      const temp1 = [...tags];
      // remove tags no longer selected
      const temp2 = temp1.filter((tag) => newTagIds.includes(tag.id));
      // add newly selected tags
      newTagIds.forEach((newTagId) => {
        if (!temp2.find((tag1) => tag1.id === newTagId)) {
          // add the whole data set for this tag, not just id
          temp2.push(tagsList.find((tag2) => tag2.id == newTagId));
        }
      });
      setAttributes({ tags: temp2 });
    };

    const onColumnsChange = (newColumns) => {
      setAttributes({ columns: newColumns });
    };

    // Use the useBlockProps hook to apply block props to the wrapper element
    const blockProps = useBlockProps({ className: `custom-block ${isSelected ? "is-selected" : ""}` });
    return (
      <div {...blockProps}>
        <InspectorControls>
          <PanelBody title="Block Settings" initialOpen={true}>
            <TextControl
              label="Title"
              help="What should the heading above this grid of posts say?"
              value={title}
              onChange={onTitleChange}
            ></TextControl>
            <RangeControl label="Columns" value={columns} min={1} max={4} onChange={onColumnsChange} />
            <ToggleControl
              label="Include a link below the grid to another page?"
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
            <SelectControl
              label="Tags"
              multiple
              help="Hold CTRL (or CMD) to select multiple tags or unselect a tag"
              value={tags.map((tag) => tag.id)}
              options={
                tagsList
                  ? tagsList.map((tag) => ({
                      value: tag.id,
                      label: tag.name,
                    }))
                  : []
              }
              onChange={onTagsChange}
              menuPlacement="bottom"
              menuPosition="fixed"
              style={{ height: "200px" }}
              filterOption={(option, searchText) => option.label.toLowerCase().includes(searchText.toLowerCase())}
              isSearchable={true}
            />
            <>
              {tags.length > 0 &&
                tags.map((tag, index) => (
                  <div key={index} style={{ margin: "1rem", textAlign: "center", paddingBottom: "0.5rem" }}>
                    <MediaUploadCheck>
                      <MediaUpload
                        onSelect={(media) => {
                          console.log(media);
                          const newTags = [...tags];
                          newTags[index].image = media;
                          setAttributes({ tags: newTags });
                        }}
                        value={JSON.stringify(tag.image)}
                        render={({ open }) => (
                          <div>
                            {tag.image && (
                              <img
                                src={tag.image.url}
                                alt={tag.image.alt}
                                style={{ maxWidth: "100px", maxHeight: "100px" }}
                              />
                            )}
                            <button
                              style={{ whiteSpace: "normal", lineHeight: "1.5", padding: "0.5rem", height: "auto" }}
                              className="components-button is-primary"
                              onClick={open}
                            >
                              {tag.image
                                ? `Change Thumbnail for Tag: ${tag.name}`
                                : `Select Thumbnail for Tag: ${tag.name}`}
                            </button>
                          </div>
                        )}
                      />
                    </MediaUploadCheck>
                  </div>
                ))}
            </>
          </PanelBody>
        </InspectorControls>
        <div className="block-preview wp-block" style={{ border: "1px solid black", margin: "0.3rem" }}>
          <div>
            <code>PREVIEW PAGE TO VIEW TAG GRID "{title}"</code>
          </div>
        </div>
      </div>
    );
  },
});
