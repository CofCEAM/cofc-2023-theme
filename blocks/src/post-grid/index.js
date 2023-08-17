import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { PanelBody, RangeControl, SelectControl, ToggleControl, TextControl } from "@wordpress/components";
import { registerBlockType } from "@wordpress/blocks";
import metadata from "./block.json";
import PostGrid from "./PostGrid";

registerBlockType(metadata.name, {
  title: "CofC Post Grid",
  edit: ({ attributes, setAttributes, isSelected }) => {
    const categoriesList = useSelect(
      (select) => select("core").getEntityRecords("taxonomy", "category", { per_page: -1 }),
      []
    );

    const tagsList = useSelect(
      (select) => select("core").getEntityRecords("taxonomy", "post_tag", { per_page: -1 }),
      []
    );

    const {
      categories,
      tags,
      limit,
      offset,
      columns,
      useFullWidth,
      title,
      includeLink,
      linkUri,
      linkText,
      linkNewTab,
      displayExcerpt,
      displayPublishDate,
      displayAuthor,
    } = attributes;

    const onCategoriesChange = (newCategories) => {
      setAttributes({ categories: newCategories });
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

    const onUseFullWidthChange = (newUseFullWidth) => {
      setAttributes({ useFullWidth: newUseFullWidth });
    };
    const onTitleChange = (newTitle) => {
      setAttributes({ title: newTitle });
    };

    const onTagsChange = (newTags) => {
      setAttributes({ tags: newTags });
    };

    const onLimitChange = (newLimit) => {
      setAttributes({ limit: newLimit });
    };

    const onOffsetChange = (newOffset) => {
      setAttributes({ offset: newOffset });
    };

    const onColumnsChange = (newColumns) => {
      setAttributes({ columns: newColumns });
    };

    const onDisplayExcerptChange = (newDisplayExcerpt) => {
      setAttributes({ displayExcerpt: newDisplayExcerpt });
    };
    const onDisplayPublishDateChange = (newDisplayPublishDate) => {
      setAttributes({ displayPublishDate: newDisplayPublishDate });
    };
    const onDisplayAuthorChange = (newDisplayAuthor) => {
      setAttributes({ displayAuthor: newDisplayAuthor });
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
            <ToggleControl
              label="Full Screen Width"
              help="Should each item in the grid take up the full width of the grid?"
              checked={useFullWidth}
              onChange={onUseFullWidthChange}
            ></ToggleControl>
            <ToggleControl
              label="Display Post Excerpts?"
              checked={displayExcerpt}
              onChange={onDisplayExcerptChange}
            ></ToggleControl>
            <ToggleControl
              label="Display Post Publish Dates?"
              checked={displayPublishDate}
              onChange={onDisplayPublishDateChange}
            ></ToggleControl>
            <ToggleControl
              label="Display Post Authors?"
              checked={displayAuthor}
              onChange={onDisplayAuthorChange}
            ></ToggleControl>
            <ToggleControl
              label="Include a link below the post grid to another page?"
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
              label="Categories"
              multiple
              help="Hold CTRL (or CMD) to select multiple categories"
              value={categories}
              options={
                categoriesList
                  ? categoriesList.map((category) => ({
                      value: category.id,
                      label: category.name,
                    }))
                  : []
              }
              onChange={onCategoriesChange}
              menuPlacement="bottom"
              menuPosition="fixed"
              style={{ height: "200px" }}
              filterOption={(option, searchText) => option.label.toLowerCase().includes(searchText.toLowerCase())}
              isSearchable={true}
            />
            <SelectControl
              label="Tags"
              multiple
              help="Hold CTRL (or CMD) to select multiple tags"
              value={tags}
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
            <RangeControl label="Limit" value={limit} min={0} max={10} onChange={onLimitChange} />
            <RangeControl label="Offset" value={offset} min={0} max={10} onChange={onOffsetChange} />
            <RangeControl label="Columns" value={columns} min={1} max={4} onChange={onColumnsChange} />
          </PanelBody>
        </InspectorControls>
        <div className="block-preview wp-block" style={{ border: "1px solid black", margin: "0.3rem" }}>
          <div>
            <code>PREVIEW PAGE TO VIEW POST GRID "{title}"</code>
          </div>
        </div>
      </div>
    );
  },
});
